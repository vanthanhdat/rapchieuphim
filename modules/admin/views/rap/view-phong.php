<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$attribute = json_decode($rap->attributes);
$unavailable_seats = ['10_8', '10_9', '10_10','10_11', '10_12', '10_13','10_14', '10_15'];
$tickets = 2;
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Danh sách rạp', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $attribute->name, 'url' => ['view','id' => $rap->id]];
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs('
	var firstSeatLabel = 1;
	$(document).ready(function() {
		var arr = '.$model->sodo.';
		var tickets = new Array();             
		var $cart = $("#selected-seats"),
		$counter = $("#counter"),
		$total = $("#total"),
		sc = $("#seat-map").seatCharts({
			map: arr,
			/*
			seats: {
				e: {
					price   : 40,
					classes : "economy-class",
					category: "Economy Class"
				}                   

				},*/
				naming : {
					top : false,
					getLabel : function (character, row, column) {
						return firstSeatLabel++;
						},
						},
						legend : {
							node : $("#legend"),
							items : [
							["a", "available",   "Có thể chọn"],
							["a", "unavailable", "Đã bán"],
							]                   
							},
							click: function () {
								if (this.status() == "available") {
									if (tickets.length < '.$tickets.' ) {
										$("<b>"+this.settings.label+"&nbsp;</b>")
										.attr("id", "cart-item-"+this.settings.id)
										.data("seatId", this.settings.id)
										.appendTo($cart);
										tickets.push(this.settings.id);
                               			// alert(this.settings.id);
										return "selected";
										}else{
											$("#cart-item-"+tickets[0]).remove();
											sc.status(tickets[0],"available");
											tickets.shift();
											$("<b>"+this.settings.label+"&nbsp;</b>")
											.attr("id", "cart-item-"+this.settings.id)
											.data("seatId", this.settings.id)
											.appendTo($cart);
											tickets.push(this.settings.id);
                               // alert(tickets.length + " " + tickets);
											return "selected";
										} 
									}
									else if (this.status() == "selected") {
										tickets.splice(tickets.indexOf(this.settings.id),1);
                           // alert(tickets.length + " " + tickets);
										$("#cart-item-"+this.settings.id).remove();
                            //seat has been vacated
										return "available";
										} else if (this.status() == "unavailable") {
                            //seat has been already booked
											return "unavailable";
											} else {
												return this.style();
											}
										}
										});

                //this will handle "[cancel]" link clicks
										$("#selected-seats").on("click", ".cancel-cart-item", function () {
                    //lets just trigger Click event on the appropriate seat, so we dont have to repeat the logic here
											sc.get($(this).parents("li:first").data("seatId")).click();
											});

                //lets pretend some seats have already been booked
											var selectedSeats = '.json_encode($unavailable_seats).';
											sc.get(selectedSeats).status("unavailable");
											});
											function recalculateTotal(sc) {
												var total = 0;
												sc.find("selected").each(function () {
													total += this.data().price;
													});
													return total;
												}	
												');
												?>
												<div class="container">
													<p id="selected-seats">
													</p>
													<div id="seat-map" class="col-md-7">
														<div class="front-indicator"><i class="fa fa-desktop fa-5x"></i></div>
													</div>
													<div class="col-md-5">
														<?php $form = ActiveForm::begin(); ?>

														<?= $form->field($model, 'name') ?>

														<div class="form-group" style="text-align: center;background-color: #3c8dbc;color: white;"><b>Screen</b></div><br>

														<?= $form->field($model,'sodo')->textArea(['rows' => 15,'value' => implode(','."\n", json_decode($model->sodo))]) ?>

														<div class="form-group">
															<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
														</div>
														<?php ActiveForm::end(); ?>
														<div class="row">
															<b>Chú thích:</b>
															<p><strong>_</strong> đại diện chỗ trống trong phòng.</p>
															<p><strong>Các chữ cái</strong> đại diện các ghế</p>
															<p><strong>Các hàng ghế</strong> được ngăn cách bằng dấu <strong>","</strong> .</p>
														</div>
													</div>
												</div>

