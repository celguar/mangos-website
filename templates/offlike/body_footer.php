                                                            
                                                            <!-- Component body END -->
                                                            </div>
                                                            </div>
                                                          </div>
                                                        </div>
                                                      </div>
                                                      <div id="cnt-bot">
                                                        <div>
                                                          <div>&nbsp;</div>
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </td>
<?php if(empty($_GET['n'])||$_GET['n']=="frontpage"): ?>
                                                  <td valign="top" style="padding-left: 21px;padding-top: 5px;">
<?php include(dirname(__FILE__).'/body_right.php'); ?>
                                                  </td>
<?php endif; ?>
                                                </tr>
                                              </table>                      
                                            </div>
                                          </div>
                                        </div>
                                        <div style="clear: both; font-size: 1px;">&nbsp;</div>
                                        <center>
										
                                          <div id="copyright">
										  <div id="blizzlogo-bot">
                                              <img alt="Blizzard.com" border="0" src="<?php echo $currtmp;?>/images/bot-blizzlogo.gif"/></div>
                                            <span class="textlinks">
                                            <small>
                                              <?php echo $lang['pagegenerated'];?> <?php echo round($exec_time,4);?> sec.
                                              Query's: (RDB: <?php echo $DB->_statistics['count']; ?>,
                                              WSDB: <?php echo $WSDB->_statistics['count']?>,
                                              CHDB: <?php echo $CHDB->_statistics['count']?>)<br/>
                                              <b>&copy; <?php echo (string)$MW->getConfig->generic->copyright; ?></b>
                                              <br/>
                                              <a class="small" href="index.php?n=html&amp;text=license">GNU GPL Licence</a> |
                                              <a href="http://validator.w3.org/check?uri=<?php echo urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']); ?>">Validate XHTML</a> |
                                              <a href="http://jigsaw.w3.org/css-validator/validator?uri=<?php echo urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']); ?>">Validate CSS</a> |
                                              <a href="http://validator.w3.org/feed/check.cgi?url=<?php echo urlencode('http://'.$_SERVER['HTTP_HOST'].(str_replace('index.php','',$_SERVER['PHP_SELF'])).'core/cache/rss/news.xml'); ?>">Validate RSS</a>
                                            </small></span><br><br><br>
                                          </div>
                                        </center>
                                      </div>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>
                                      <div id="main-bottom">
                                        <div>
                                          <div>
                                          </div>
                                        </div>
                                      </div>
                                    </td>
                                  </tr>
                                </table>
                              </div>
                            </div>
                            <div style="position: relative; z-index: 10;">
                              <img style="position: absolute; top: -445px; left: -243px;" alt="statue" src="./templates/vanilla/images/statue.png"/></div>
                          </div>
                        </div>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </td>
        </tr>
      </table>
    </center>
    <div id="ironframe" style="z-index: 11;"></div>
    <div id="pageend"></div>
      <script type="text/javascript" src="js/wz_tooltip.js"></script>
  </body>
</html>