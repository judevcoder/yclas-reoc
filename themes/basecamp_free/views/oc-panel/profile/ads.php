<?php defined('SYSPATH') or die('No direct script access.');?>
<div class="pad_10tb">
	<div class="container">
		<div class="col-xs-12">
			<div class="page-header">
				<h3>
					<?=_e('My Advertisements')?>
				</h3>
			</div>

			<?=Alert::show()?>

			<? $i = 0; foreach($ads as $ad):?>
				<div class="my_ad_item">
					<div class="my_ad_body clearfix">
						<div class="ad_pcoll">
							<div class="pad_10">
							<?if($ad->get_first_image() !== NULL):?>
								<img src="<?=$ad->get_first_image()?>" alt="<?=HTML::chars($ad->title)?>" />
							<?else:?>
								<img data-src="holder.js/<?=core::config('image.width_thumb')?>x<?=core::config('image.height_thumb')?>?<?=str_replace('+', ' ', http_build_query(array('text' => $ad->category->translate_name(), 'size' => 14, 'auto' => 'yes')))?>" alt="<?=HTML::chars($ad->title)?>">
							<?endif?>
							</div>
						</div>

						<div class="ad_dcoll">
							<div class="pad_10">
								<div class="my_ad_title clearfix">
									<div class="dropdown pull-right display-inline-block">
										<button class="btn btn-base-dark btn-sm dropdown-toggle " type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><span class="glyphicon glyphicon-option-vertical"></span></button>
											<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
												<? if (in_array($ad->status, [Model_Ad::STATUS_UNAVAILABLE, Model_Ad::STATUS_SOLD]) AND !in_array(core::config('general.moderation'), Model_Ad::$moderation_status)):?>
													<?if ( ($order = $ad->get_order()) === FALSE OR ($order !== FALSE AND $order->status == Model_Order::STATUS_PAID) ):?>
														<li>
															<a href="<?=Route::url('oc-panel', array('controller'=>'myads','action'=>'activate','id'=>$ad->id_ad))?>"><?=_e('Activate?')?></a>
														</li>
													<?endif?>
												<?elseif($ad->status != Model_Ad::STATUS_UNAVAILABLE):?>
													<li><a href="<?=Route::url('oc-panel', array('controller'=>'myads','action'=>'deactivate','id'=>$ad->id_ad))?>"><?=_e('Deactivate?')?></a>
												<?endif?>
                    							<?if(core::config('advertisement.count_visits')):?>
												<li><a href="<?=Route::url('oc-panel', array('controller'=>'myads','action'=>'stats','id'=>$ad->id_ad))?>"><?=_e('Stats')?></a></li>
												<?endif?>
												<li><a href="<?=Route::url('oc-panel', array('controller'=>'myads','action'=>'update','id'=>$ad->id_ad))?>"><?=_e('Update')?></a></li>
												<?if(core::config('advertisement.delete_ad')==TRUE):?>
							                        <li>
							                        <a
							                            href="<?=Route::url('oc-panel', array('controller'=>'myads','action'=>'delete','id'=>$ad->id_ad))?>" onclick="return confirm('<?=__('Delete?')?>');">
							                            <?=__('Delete')?>
							                        </a>
							                        </li>
							                    <?endif?>
												<li role="separator" class="divider"></li>
												<?if( core::config('payment.to_top') ):?>
													<li><a href="<?=Route::url('default', array('controller'=>'ad','action'=>'to_top','id'=>$ad->id_ad))?>"><?=_e('Go to top')?>?</a>
												<?endif?>
												<?if( core::config('payment.to_featured')):?>
													<li>
													<?if($ad->featured == NULL):?>
														<a href="<?=Route::url('default', array('controller'=>'ad','action'=>'to_featured','id'=>$ad->id_ad))?>"
														onclick="return confirm('<?=__('Make featured?')?>');" rel="tooltip" title="<?=__('Featured')?>"
														data-id="tr1" data-text="<?=__('Are you sure you want to make it featured?')?>"><?=_e('Make featured?')?>
														</a>
													<?else:?>
														<a href="#"><?=_e('Featured')?> til <?= Date::format($ad->featured, core::config('general.date_format'))?></a>
													<?endif?>
													</li>
												<?endif?>
											</ul>
									</div>
									<? foreach($category as $cat){ if ($cat->id_category == $ad->id_category) $cat_name = $cat->seoname; }?>
										<a class="at" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$cat_name,'seotitle'=>$ad->seotitle))?>"><?= $ad->title; ?></a>
								</div>

								<p><b><?=_e('Date')?> : </b><?= Date::format($ad->published, core::config('general.date_format'))?></p>
								<? foreach($category as $cat):?>
									<? if ($cat->id_category == $ad->id_category): ?>
										<p><b><?=_e('Category')?> : </b><?= $cat->name ?></p>
									<?endif?>
								<?endforeach?>
								<?$locat_name = NULL;?>
								<?foreach($location as $loc):?>
									<? if ($loc->id_location == $ad->id_location):$locat_name=$loc->name;?>
										<p><b><?=_e('Location')?> : </b><?=$locat_name?></p>
									<?endif?>
								<?endforeach?>
								<?if($locat_name == NULL):?>
									<p><b><?=_e('Location')?> : </b>n/a</p>
								<?endif?>
								<p><b><?=_e('Status')?> : </b>
								<?if($ad->status == Model_Ad::STATUS_NOPUBLISHED):?>
									<span class="badge"><?=_e('Not published')?></span>
								<? elseif($ad->status == Model_Ad::STATUS_PUBLISHED):?>
									<span class="badge badge-success"><?=_e('Published')?></span>
								<? elseif($ad->status == Model_Ad::STATUS_SPAM):?>
									<span class="badge badge-warning"> <?=_e('Spam')?></span>
								<? elseif($ad->status == Model_Ad::STATUS_UNAVAILABLE):?>
									<span class="badge badge-danger"><?=_e('Unavailable')?></span>
								<? elseif($ad->status == Model_Ad::STATUS_SOLD):?>
									<span class="badge badge-danger"><?=_e('Sold')?></span>
								<?endif?>
								</p>
								<p class="text-right">
									<?if( ($order = $ad->get_order())!==FALSE ):?>
										<?if ($order->status==Model_Order::STATUS_CREATED AND $ad->status != Model_Ad::STATUS_PUBLISHED):?>
											<a class="btn btn-warning" href="<?=Route::url('default', array('controller'=> 'ad','action'=>'checkout' , 'id' => $order->id_order))?>">
											<i class="glyphicon glyphicon-shopping-cart"></i> <?=_e('Pay')?>  <?=i18n::format_currency($order->amount,$order->currency)?> 
											</a>
										<?elseif ($order->status==Model_Order::STATUS_PAID):?>
											<a class="btn btn-warning disabled" href="#" disabled>
												<?=_e('Paid')?>
											</a>
										<?endif?>
									<?endif?>
								</p>
							</div>
						</div>
					</div>
				</div>
			<?endforeach?>

			<div class="text-center">
				<?=$pagination?>
			</div>

		</div>
	</div>
</div>
