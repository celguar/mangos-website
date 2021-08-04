ALTER TABLE `voting_points` 
ADD `times_voted` smallint(5) NOT NULL DEFAULT '0',
ADD `points_earned` bigint(20) NOT NULL DEFAULT '0',
ADD `points_spent` bigint(20) NOT NULL DEFAULT '0';