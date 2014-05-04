<?php

session_start();

// Check auth status
if(!$_SESSION['logged_in']){
    header("HTTP/1.1 401 Unauthorized");
    header('Location: login.php');
    exit;
}

// Set vars and render header
$css_files = array('results');
$js_files = array('results');
$title = 'Stream Send Results';
$page = 'results';
include('include/header.php');

// Fetch addresses from Loewy API
$addresses = json_decode(file_get_contents('http://snippets.loewydesign.com/googleapi?api_key=9TQQN6fK-D4GgOx8i-Uc59Q2ZD'));
$locations = $addresses->locations;

// Fetch lat/lng from Google GeoCache API - Anonymous Account
foreach ($locations as $address){
    $formatted_add = $address->street.' '.$address->city.', '.$address->state.' '.$address->zipcode;
    $formatted_add = str_replace(' ', '+',$formatted_add);
    $json_location = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=$formatted_add&sensor=false"));
    if(!$json_location){
        die("Unable to fetch lat/lng from Google Geocache API.");
    }
    $address->lat= $json_location->results[0]->geometry->location->lat;
    $address->lng = $json_location->results[0]->geometry->location->lng;
}

?>
<div class="constrain">
    <div class="top cf">
        <h3 class="greeting">Welcome <?php echo $_SESSION['name']; ?> (<a href="logout.php" title="Log Out">Log Out</a>)</h3>
    </div>
    <div class="locations">
        <?php foreach ($locations as $address) { ?>
            <section class="location cf">
                <div class="address">
                    <h2>Location Address</h2>
                    <p><?php echo $address->street; ?></p>
                    <p><?php echo $address->city.' '.$address->state.', '.$address->zipcode; ?></p>
                </div>
                <div class="mapContain">
                    <h2>Map</h2>
                    <div class="mapBorder">
                        <div class="map" data-lat="<?php echo $address->lat; ?>" data-lng="<?php echo $address->lng; ?>"></div>
                    </div>
                </div>
            </section>
        <?php } ?>
    </div>
</div>
<?php

// Render footer
include('include/footer.php');
