    </body>
    <script src="js/jquery-2.1.1.min.js"></script>
    <?php
    if ($page == 'results'){
    	echo '<script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>';
    }
    foreach ($js_files as $file){
    	echo '<script src="js/'.$file.'.js?h=d" type="text/javascript"></script>';
    }
    ?>
</html>