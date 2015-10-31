<?php


echo "<br/>start<br/>";

// retrieve EAN details
$cid = get_option('ean_cid');
$key = get_option('ean_key');
$sec = get_option('ean_secret');

// instantiate EAN class
$psean = new PS_EAN_API( $cid, $key, $sec );

// TODO:
// instead of hard-coding the location
// receive this from the widget

// test hotel list call

//receiving location from widget

$country = $wp_query->query_vars['ean_country'];
$province = $wp_query->query_vars['ean_prov'];
$city = $wp_query->query_vars['ean_city'];
$hotels = $psean->getHotelList( $country, $province, $city );

echo "<br/>";

foreach ($hotels as $key => $hotel) {
	// echo "bars: $key @ $value<br/><br/>";
	// var_dump( $hotel );
	?>
	
	
	<div role='hotel' style='border:1px solid blue;'>
		<img src='<?php echo PS_EAN_API::$IMGURL.$hotel->{'thumbNailUrl'} ?>' />
		<h3><?php echo $hotel->{'name'} ?></h3>
		
		
		<div id="rate"></div>
		<?php
		$r =  $hotel->{'hotelRating'};
		// TODO:
		// do not round, instead display full and half stars
		$n = round($r); 
		$x = 0;
		for( $x; $x<$n; $x++ ){
			echo "★";
		}
		?>
		<!-- <div role='ranking'><?php echo $hotel->{'hotelRating'} ?>/5 stars</div> -->
		<div role='address'><?php echo $hotel->{'address1'} .", ". $hotel->{'city'} .",". $hotel->{'countryCode'} ?><div>
		<?php /*
			<iframe
			  width="200"
			  height="200"
			  frameborder="0" style="border:0"
			  src="https://www.google.com/maps/embed/v1/view?key=AIzaSyBsQ_K-mlyd_eaBqo7Ms7-2GLunFapyZYI&center=<?php echo $hotel->{'latitude'}.",".$hotel->{'longitude'}?>&zoom=18">
			</iframe>
		*/ ?>
		<!-- <div role='reviews'>?reviews?</div> -->
		<div role='rate'>
			$<?php echo $hotel->{'RoomRateDetailsList'}->{'RoomRateDetails'}->{'RateInfo'}->{'ChargeableRateInfo'}->{'NightlyRatesPerRoom'}->{'NightlyRate'}->{'@rate'} ?>
			<?php echo $hotel->{'RoomRateDetailsList'}->{'RoomRateDetails'}->{'RateInfo'}->{'ChargeableRateInfo'}->{'@currencyCode'} ?>
		</div>

		<!-- button -->
		<br/>
		<?php $url = get_site_url() . '/' . get_option('psean_base_url') . '/hotel/' . $hotel->{'hotelId'}; ?>
		<a href='<?php echo $url; ?>'>[ Select ]</a>
		<?php /*
		<form method="get" action="/views/info.php">
		<input type="hidden"  name="hotelid" value="<?php echo $hotel->{'hotelId'} ?>"></input>
		<input type="submit" role='select' value="Select <?php echo $hotel->{'hotelId'} ?>"></input>
		</form>
		*/ ?>
	</div>
	<?php
	// echo var_dump( $hotel[ $key ] );
}

echo "<br/>finish<br/>";
