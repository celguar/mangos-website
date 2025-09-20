<?php
if (!defined('Armory')) { exit; }

/**
 * character-talents.php
 * - class/tab backgrounds witch icons
 * - hover tooltips from dbc_spell with plain text
 ++*
 * Requires (your current schema):
 *   armory.dbc_talenttab(id, name, refmask_chrclasses, tab_number)
 *   armory.dbc_talent(id, ref_talenttab, row, col, rank1..rank5)
 *   armory.dbc_spell(id, ref_spellicon, name, description, ...)
 *   armory.dbc_spellicon(id, name)
 */


/* -------------------- helpers -------------------- */

/** table exists in given connection */
function tbl_exists($conn, $table) {
	if (!preg_match('/^[A-Za-z0-9_]+$/', $table)) return false;
  return (bool) execute_query(
    $conn,
    "SELECT 1 FROM information_schema.TABLES
      WHERE TABLE_SCHEMA = DATABASE()
         AND TABLE_NAME = '{$table}'
      LIMIT 1",
    2
  );
}
function get_talent_cap(?int $level): int {
  if (!$level || $level < 10) return 0;
  return max(0, $level - 9);
}


/** tabs (id, name, tab_number) for a class id */
function get_tabs_for_class($classId) {
  $mask = 1 << ((int)$classId - 1);
  return execute_query(
    'armory',
    "SELECT `id`, `name`, `tab_number`
       FROM `dbc_talenttab`
      WHERE (`refmask_chrclasses` & {$mask}) <> 0
      ORDER BY `tab_number` ASC",
    0
  ) ?: [];
}

/** fast learned-spells lookup (cached per guid;) */
function get_learned_spells_map(int $guid): array {
  return _cache("learned:".$guid, function() use ($guid){
    if (!tbl_exists('char', 'character_spell')) return [];
    $rows = execute_query(
      'char',
      "SELECT `spell` FROM `character_spell`
        WHERE `guid`=".(int)$guid." AND `disabled`=0",
      0
    ) ?: [];
    $map = [];
    foreach ($rows as $r) { $map[(int)$r['spell']] = true; }
    return $map;
  });
}

/** prefer character_talent; else derive from character_spell (no per-cell queries) */
function current_rank_for_talent(int $guid, array $talRow, array $rankMap, bool $hasCharSpell): int {
  $tid = (int)$talRow['id'];
  if (isset($rankMap[$tid])) return (int)$rankMap[$tid]; // already 1-based
  if ($hasCharSpell) {
    $learned = get_learned_spells_map($guid);            // cached O(1) lookups
    for ($r = 5; $r >= 1; $r--) {
      $spell = (int)($talRow["rank{$r}"] ?? 0);
      if ($spell > 0 && !empty($learned[$spell])) return $r;
    }
  }
  return 0;
}
/** first non-zero rank spell id */
function first_rank_spell(array $tal) {
  for ($i = 1; $i <= 5; $i++) {
    $id = (int)$tal["rank{$i}"];
    if ($id) return $id;
  }
  return 0;
}

 /** numeric formatting helper */
 function num_trim($v): string {
   $s = number_format((float)$v, 1, '.', '');
   $s = rtrim(rtrim($s, '0'), '.');
   return ($s === '') ? '0' : $s;
 }
 
 /** cached chain-target lookup */
 function get_spell_chain_targets(int $id, int $n): int {
  $n = max(1, min(3, $n));
   return _cache("chain:$id:$n", function() use ($id,$n){
     $row = execute_query('armory',
       "SELECT `effect_chaintarget_{$n}` AS x FROM `dbc_spell`
          WHERE `id`=".(int)$id." LIMIT 1", 1);
     return $row ? (int)$row['x'] : 0;
   });
 }
 

/** Spell info (name/description/icon) for the talent row at a given rank */
function spell_info_for_talent(array $talRow, int $rank = 0) {
    // find the highest non-zero rank present in DBC (1..5)
    $maxRank = 0;
    for ($r = 5; $r >= 1; $r--) {
        if (!empty($talRow["rank{$r}"])) { $maxRank = $r; break; }
    }
    if ($maxRank === 0) {
        return ['name' => 'Unknown', 'desc' => '', 'icon' => 'inv_misc_questionmark'];
    }

    // choose the spell for the requested rank (clamped), with safe fallback
    $useRank = $rank > 0 ? min($rank, $maxRank) : 1; // if unlearned, show rank 1
    $spellId = (int)($talRow["rank{$useRank}"] ?? 0);
    if ($spellId <= 0) {
        // fallback downward until we hit an existing rank
        for ($r = min($useRank, $maxRank); $r >= 1; $r--) {
            $spellId = (int)($talRow["rank{$r}"] ?? 0);
            if ($spellId > 0) break;
        }
    }
    if ($spellId <= 0) {
        return ['name' => 'Unknown', 'desc' => '', 'icon' => 'inv_misc_questionmark'];
    }

    $sql = "
        SELECT
            s.`id`, s.`name`, s.`description`,
            s.`proc_chance`,
			s.`proc_charges`,
            s.`ref_spellduration`,
            s.`ref_spellradius_1`,
            s.`effect_basepoints_1`, s.`effect_basepoints_2`, s.`effect_basepoints_3`,
            s.`effect_amplitude_1`,  s.`effect_amplitude_2`,  s.`effect_amplitude_3`,
            s.`effect_chaintarget_1`, s.`effect_chaintarget_2`, s.`effect_chaintarget_3`,
            s.`effect_trigger_1`, s.`effect_trigger_2`, s.`effect_trigger_3`,
            i.`name` AS icon
        FROM `dbc_spell` s
        LEFT JOIN `dbc_spellicon` i ON i.`id` = s.`ref_spellicon`
        WHERE s.`id` = {$spellId}
        LIMIT 1
    ";
    $sp = execute_query('armory', $sql, 1);
    if (!$sp || !is_array($sp)) {
        return ['name' => 'Unknown', 'desc' => '', 'icon' => 'inv_misc_questionmark'];
    }

    $desc = build_tooltip_desc($sp);

    $icon = strtolower(preg_replace('/[^a-z0-9_]/i', '', (string)($sp['icon'] ?? '')));
    if ($icon === '') $icon = 'inv_misc_questionmark';

    return ['name' => (string)($sp['name'] ?? 'Unknown'), 'desc' => $desc, 'icon' => $icon];
}

/** icon web path */
function icon_url($iconBase) {
  return '/armory/images/icons/64x64/' . $iconBase . '.png';
}

/** class/tab background by talent tab id (e.g. 161.jpg) */
function talent_bg_for_tab($tabId) {
  $webBase = '/armory/images/talents_background';
  $fsBase  = realpath(__DIR__ . '/../images/talents_background');
  if (!$fsBase) return '';
  $file = (int)$tabId . '.jpg';
  $fs   = $fsBase . DIRECTORY_SEPARATOR . $file;
  return is_file($fs) ? ($webBase . '/' . $file) : '';
}

/* -------------------- build data -------------------- */

$tabs = get_tabs_for_class($stat['class']);

/* rank map from character_talent (normalize to 1-based) */
$rankMap = array();
$hasCharTalent = tbl_exists('char', 'character_talent');
if ($hasCharTalent) {
  $rows = execute_query(
    'char',
    "SELECT `talent_id`, `current_rank`
       FROM `character_talent`
      WHERE `guid` = ".(int)$stat['guid'],
    0
  );
  foreach ((array)$rows as $r) {
    $rankMap[(int)$r['talent_id']] = ((int)$r['current_rank']) + 1; // 0-based -> 1-based
  }
}
$hasCharSpell = tbl_exists('char', 'character_spell');

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Character Talents</title>

  <?php
    $cssPath = $_SERVER['DOCUMENT_ROOT'].'/armory/css/talents.css';
    $jsPath  = $_SERVER['DOCUMENT_ROOT'].'/armory/js/talents.js';
  ?>
  <link rel="stylesheet" href="/armory/css/talents.css<?= is_file($cssPath) ? '?v='.filemtime($cssPath) : '' ?>">
  <script defer src="/armory/js/talents.js<?= is_file($jsPath) ? '?v='.filemtime($jsPath) : '' ?>"></script>
</head>
<body class="show-guides">

<div class="parchment-top">
    <div class="parch-profile-banner" id="banner" style="position: absolute;margin-left: 450px!important;margin-top: -110px!important;">
        <h1 style="padding-top: 12px!important;"><?php echo $lang["talents"] ?></h1>
    </div></div>

<div class="parchment-top"></div>

<div class="parchment-content">

<?php if (empty($tabs)): ?>
  <!-- If no talent tabs are available for this class, show a fallback message -->
  <em>No talent tabs found for this class.</em>
<?php else: ?>
  
 
  <div class="talent-trees">
   
		  <?php foreach ($tabs as $t): ?>
			<?php
			  // Basic info about the talent tab
			  $tabId   = (int)$t['id'];
			  $tabName = (string)$t['name'];
			  $points  = (int)talentCounting($stat['guid'], $tabId);
			  $bgUrl   = talent_bg_for_tab($tabId);

			  // Fetch all talents for this tab
			  $talents = execute_query(
				'armory',
				"SELECT `id`, `row`, `col`, `rank1`, `rank2`, `rank3`, `rank4`, `rank5`
				   FROM `dbc_talent`
				  WHERE `ref_talenttab` = {$tabId}
				  ORDER BY `row`, `col`",
				0
			  ) ?: [];

			  // Index talents by row/column and track deepest row
			  $byPos = []; 
			  $maxRow = 0;
			  foreach ($talents as $tal) {
				$r = (int)$tal['row'];
				$c = (int)$tal['col'];
				$byPos["$r:$c"] = $tal;
				if ($r > $maxRow) $maxRow = $r;
			  }

			  // Pick a tab icon (first valid talent spell’s icon for now)
			  $tabIconName = (function() use ($talents){
				foreach ($talents as $tal) {
				  $sid = first_rank_spell($tal);
				  if ($sid) {
					$r = execute_query('armory',
					  "SELECT i.`name` AS icon
						 FROM `dbc_spell` s
						 LEFT JOIN `dbc_spellicon` i ON i.`id` = s.`ref_spellicon`
						WHERE s.`id` = ".(int)$sid." LIMIT 1", 1);
					if ($r && !empty($r['icon'])) {
					  return strtolower(preg_replace('/[^a-z0-9_]/i', '', $r['icon']));
					}
				  }
				}
				return 'inv_misc_questionmark';
			  })();

			  $tabIconUrlQ = htmlspecialchars(icon_url($tabIconName), ENT_QUOTES);
			  $talentCap   = get_talent_cap(isset($stat['level']) ? (int)$stat['level'] : null);
              $realTalentCap = get_talent_cap(CLIENT ? (CLIENT > 1 ? 80 : 70) : 60);
			?>

				<!-- One talent tree column -->
				<div class="talent-tree" style="background-image:url('<?= htmlspecialchars($bgUrl, ENT_QUOTES) ?>');">
						  <div class="talent-head">
							<span class="talent-head-ico" style="background-image:url('<?= $tabIconUrlQ ?>')"></span>
							<span class="talent-head-title"><?= htmlspecialchars($tabName) ?></span>
							<span class="talent-head-pts">
							  <b class="num"><?= (int)$points ?></b>
							  <span class="slash"> / </span>
							  <span class="cap"><?= (int)$realTalentCap ?></span>
							</span>
						  </div>

									  <!-- 4-column grid for talents -->
									  <div class="talent-flex">
										<?php
										  $cols = 4;
										  for ($r = 0; $r <= $maxRow; $r++) {							//row loop
											for ($c = 0; $c < $cols; $c++) {							//col loop	
												if (!isset($byPos["$r:$c"])) {										
												echo '<div class="talent-cell placeholder"></div>';
												continue;
											  }
											  $found = $byPos["$r:$c"];

											$max = 0;													//“current/max” and color the cell correctly green/yellow				
											for ($x = 5; $x >= 1; $x--) {
											  if (!empty($found["rank$x"])) { $max = $x; break; }
}


											  // Current trained rank
											  $cur = current_rank_for_talent((int)$stat['guid'], $found, $rankMap, $hasCharSpell);

											  // Spell info
											  $sp = spell_info_for_talent($found, $cur > 0 ? $cur : 1);
											  $title = htmlspecialchars($sp['name'], ENT_QUOTES);
											  $desc  = htmlspecialchars($sp['desc'], ENT_QUOTES);
											  $icon  = icon_url($sp['icon']);
											  $iconQ = htmlspecialchars($icon, ENT_QUOTES);

											  // Cell state
											  $cellClass = 'talent-cell';
											  if ($cur >= $max && $max > 0)      $cellClass .= ' maxed';
											  elseif ($cur > 0)                  $cellClass .= ' learned';
											  else                               $cellClass .= ' empty';

											  // Render cell
											  echo '<div class="'.$cellClass.'" style="--icon:url(\''.$iconQ.'\')"
														data-tt-title="'.$title.'"
														data-tt-desc="'.$desc.'">
													  <span class="talent-rank">'.(int)$cur.'/'.(int)$max.'</span>
													</div>';
											}
										  }
										?>
									  </div>
				</div>
		  <?php endforeach; ?>
    </div>
  </div>
<?php endif; ?>


</body>
</html>
