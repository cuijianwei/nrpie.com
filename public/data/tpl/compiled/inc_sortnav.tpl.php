<? if(!defined('IN_FANWE')) exit('Access Denied'); ?>
<div class="sortall">
<h1 class="yahei"><?=$title?></h1>
<div class="sort_order">
                    <span class="sort_span">排序:</span>
                    <ul>
                        <li class="c_sort_l"><a <? if($new_url['act'] == 1) { ?>class="c"<? } ?> href="<?=$new_url['url']?>"><i></i><span>最新</span></a></li>
                        <li class="c_sort_c"><a <? if($hot7_url['act'] == 1) { ?>class="c"<? } ?> href="<?=$hot7_url['url']?>"><span>最热</span></a></li>
                        <li class="c_sort_r"><a <? if($pop_url['act'] == 1) { ?>class="c"<? } ?> href="<?=$pop_url['url']?>"><span>有派</span><i></i></a></li>
                    </ul>
                </div>
<div class="sort_order">
                    <span class="sort_span">价格:</span>
                    <ul>
                       <li class="c_sort_l"><a href="<?=$pall_url['url']?>" <? if($pall_url['act'] == 1) { ?>class="c"<? } ?>><i></i><span>全部</span></a></li>
                       <li class="c_sort_c"><a href="<?=$p1_url['url']?>" <? if($p1_url['act'] == 1) { ?>class="c"<? } ?>><span>100元</span></a></li>
                       <li class="c_sort_c"><a href="<?=$p2_url['url']?>" <? if($p2_url['act'] == 1) { ?>class="c"<? } ?>><span>200元</span></a></li>
                       <li class="c_sort_c"><a href="<?=$p3_url['url']?>" <? if($p3_url['act'] == 1) { ?>class="c"<? } ?>><span>500元</span></a></li>
                       <li class="c_sort_r"><a href="<?=$phigh_url['url']?>" <? if($phigh_url['act'] == 1) { ?>class="c"<? } ?>><span>更高</span><i></i></a></li>	
                    </ul>
                </div>
<div class="sort_order">
                    <span class="sort_span">颜色:</span>
                    <div class="cate_color">
                       <b class="lft"></b>
                       <div class="mid clearfix">
                       	  <span class="tit">不限</span>
                          <div class="colbox">
                          	<div class="colbox1">
                          		<a style="background-color:red;" href="<?=$c1_url['url']?>" <? if($c1_url['act'] == 1) { ?>class="bor"<? } ?> ></a>
                            </div>
                          </div>
                          <div class="colbox">
                          	<div class="colbox1">
                          		<a style="background-color:orange;" href="<?=$c2_url['url']?>" <? if($c2_url['act'] == 1) { ?>class="bor"<? } ?>></a>
                            </div>
                          </div>
                          <div class="colbox">
                          	<div class="colbox1">
                          		<a style="background-color:yellow;" href="<?=$c3_url['url']?>" <? if($c3_url['act'] == 1) { ?>class="bor"<? } ?>></a>
                            </div>
                          </div>
                          <div class="colbox">
                          	<div class="colbox1">
                          		<a style="background-color:green;" href="<?=$c4_url['url']?>" <? if($c4_url['act'] == 1) { ?>class="bor"<? } ?>></a>
                            </div>
                          </div>
                          <div class="colbox">
                          	<div class="colbox1">
                          		<a style="background-color:blue;" href="<?=$c5_url['url']?>" <? if($c5_url['act'] == 1) { ?>class="bor"<? } ?>></a>
                            </div>
                          </div>
                          <div class="colbox">
                          	<div class="colbox1">
                          		<a style="background-color:white;" href="<?=$c6_url['url']?>" <? if($c6_url['act'] == 1) { ?>class="bor"<? } ?>></a>
                            </div>
                          </div>
                       </div>
                       <b class="rit"></b>                       
                    </div>
                </div>
</div>