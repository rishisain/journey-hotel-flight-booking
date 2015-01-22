<?php
/**
 * Template Name: Look At Deal Page
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
global $wpdb;
global $current_user;
get_header(); ?>

<div id="main-content" class="main-content">

<?php
	if ( is_front_page() && twentyfourteen_has_featured_posts() ) {
		// Include the featured content template.
		get_template_part( 'featured-content' );
		$user_ID = get_current_user_id();
	}
?>
<?php
if(isset($_POST['comment_submit']))
{
	$wpdb->insert( 
				'wp_comments', 
				array( 
					'comment_post_ID'    => $_POST["post_id"],
					'comment_content'   => mysql_real_escape_string(''.$_POST["content"].''),
				  	'user_id'  => $_POST["post_comment_id"]
				), 
				array( 
					'%d', '%s', '%d'
				) 
			);
} 
?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<?php
			if(isset($_POST["request_title"]))
			{
				// Create post object
				$my_post = array(
				  'post_title'    => ''.$_POST["request_title"].'',
				  'post_content'  => ''.$_POST["request_details"].'',
				  'post_status'   => 'pending',
				  'post_author'   => ''.$user_ID.'',
				  'post_category' => array(1)
				);

				// Insert the post into the database
				wp_insert_post( $my_post );
				$posts_array = get_posts( $my_post );
				$newest_post_id = $posts_array[0]->ID;

				//echo "request_people_alterKind_hid = ".$_POST["request_people_alterKind_hid"]." earliest_at_hid=".$_POST["earliest_at_hid"]." confirm_updates=".$_POST["confirm_updates"];
				//echo "earliest_at_hid=".$_POST["earliest_at_hid"]."latest_at_hid=".$_POST["latest_at_hid"];

				
				$wpdb->insert( 
				'wp_deal_posts', 
				array( 
					'post_id' => $newest_post_id, 
					'request_people_alterKind' => ''.$_POST["request_people_alterKind_hid"].'',
					'travel_item' => $_POST["travel_item_hid"],
					'number_of_adults' => $_POST["number_of_adults_hid"],
					'number_of_kids' => $_POST["number_of_kids_hid"],
					'departure' => ''.$_POST["departure_hid"].'',
					'destination' => ''.$_POST["destination_hid"].'',
					'departure_arrival' => ''.$_POST["departure_arrival_hid"].'',
					'destination_e' => ''.$_POST["destination_e_hid"].'',
					'destination_e_stops' => ''.$_POST["destination_e_stops_hid"].'',
					'ultimate_goal_return_location' => ''.$_POST["ultimate_goal_return_location_hid"].'',
					'number_of_departure' => ''.$_POST["number_of_departure_hid"].'',
					'number_of_wantGo' => ''.$_POST["number_of_wantGo_hid"].'',
					'number_of_except' => ''.$_POST["number_of_except_hid"].'',
					'requiresItem' => $_POST["requiresItem_hid"],
					'duration_type' => ''.$_POST["duration_type_hid"].'',
					'duration_from' => $_POST["duration_from_hid"],
					'duration_to' => $_POST["duration_to_hid"],
					'duration_unit' => ''.$_POST["duration_unit_hid"].'',
					'earliest_at' => ''.$_POST["earliest_at_hid"].'',
					'latest_at' => ''.$_POST["latest_at_hid"].'',
					'clas' => ''.$_POST["clas_hid"].'',
					'airline_type' => ''.$_POST["airline_type_hid"].'',
					'railfly' => ''.$_POST["railfly_hid"].'',
					'nearby_airports' => ''.$_POST["nearby_airports_hid"].'',
					'multistops' => ''.$_POST["multistops_hid"].'',
					'collect_miles' => ''.$_POST["collect_miles_hid"].'',
					'price_level' => ''.$_POST["price_level_hid"].'',
					'accommodation_type' => ''.$_POST["accommodation_type_hid"].'',
					'minimum_category' => $_POST["minimum_category_hid"],
					'board' => ''.$_POST["board_hid"].'',
					'tripadvisor_score' => $_POST["tripadvisor_score_hid"],
					'wlan' => ''.$_POST["wlan_hid"].'',
					'holidaycheck_score' => $_POST["holidaycheck_score_hid"],
					'notes' => ''.$_POST["notes_hid"].'',
					'request_budget' => ''.$_POST["request_budget"].'',
					'currency' => ''.$_POST["currency"].'',
					'unit_type' => ''.$_POST["unit_type"].'',
					'confirm_updates' => ''.$_POST["confirm_updates"].''

				), 
				array( 
					'%d', '%s', '%d', '%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s',	'%d', '%d',	'%s', '%s',	'%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s','%d', '%s', '%d', '%s', '%s',	'%s', '%s',	'%s'
				) 
			);

			//echo "insert_id=".$wpdb->insert_id;
			$insert_id=$wpdb->insert_id;
			echo "<script type='text/javascript'>
			location.href='?post_id=".$newest_post_id."';
			</script>";				
			}
			$post_id = $_GET['post_id'];
			$querystr = "SELECT $wpdb->posts.post_title,$wpdb->posts.post_content,$wpdb->posts.post_modified, $wpdb->posts.post_author,$wpdb->users.user_login,".$wpdb->prefix.'deal_posts'.".* FROM $wpdb->posts, ".$wpdb->prefix.'deal_posts'.",wp_users
        WHERE $wpdb->users.ID=$wpdb->posts.post_author AND ".$wpdb->prefix.'deal_posts'.".post_id = $wpdb->posts.ID 
        AND $wpdb->posts.ID = $post_id";
		    //echo $querystr;
 			$pageposts = $wpdb->get_results($querystr, OBJECT);
 			//echo "<b>post_title=</b>".$pageposts[0]->post_title;
 			//print_r($pageposts);
 			
 			// Retrieve The Post's Author ID
		    $userId = $pageposts[0]->post_author;
		    // Set the image size. Accepts all registered images sizes and array(int, int)
		    $size = 'thumbnail';

		    // Get the image URL using the author ID and image size params
		    $imgURL = get_cupp_meta($userId, $size);

			$post_title=$pageposts[0]->post_title;
			$post_content=$pageposts[0]->post_content;
			$post_modified=$pageposts[0]->post_modified;
			$user_login=$pageposts[0]->user_login;
			$id=$pageposts[0]->id;
			$post_id=$pageposts[0]->post_id;
			$request_people_alterKind=$pageposts[0]->request_people_alterKind;
			$travel_item=$pageposts[0]->travel_item;
			$number_of_adults=$pageposts[0]->number_of_adults;
			$number_of_kids=$pageposts[0]->number_of_kids;
			$departure=$pageposts[0]->departure;
			$destination=$pageposts[0]->destination;
			$departure_arrival=$pageposts[0]->departure_arrival;
			$destination_e=$pageposts[0]->destination_e;
			$destination_e_stops=$pageposts[0]->destination_e_stops;
			$ultimate_goal_return_location=$pageposts[0]->ultimate_goal_return_location;
			$number_of_departure=$pageposts[0]->number_of_departure;
			$number_of_wantGo=$pageposts[0]->number_of_wantGo;
			$number_of_except=$pageposts[0]->number_of_except;
			$requiresItem=$pageposts[0]->requiresItem;
			$duration_type=$pageposts[0]->duration_type;
			$duration_from=$pageposts[0]->duration_from;
			$duration_to=$pageposts[0]->duration_to;
			$duration_unit=$pageposts[0]->duration_unit;
			$earliest_at=$pageposts[0]->earliest_at;
			$latest_at=$pageposts[0]->latest_at;
			
			$clas=$pageposts[0]->clas;
			$airline_type=$pageposts[0]->airline_type;
			$railfly=$pageposts[0]->railfly;
			$nearby_airports=$pageposts[0]->nearby_airports;
			$multistops=$pageposts[0]->multistops;
			$collect_miles=$pageposts[0]->collect_miles;

			$price_level=$pageposts[0]->price_level;
			$accommodation_type=$pageposts[0]->accommodation_type;
			$minimum_category=$pageposts[0]->minimum_category;
			$board=$pageposts[0]->board;
			$tripadvisor_score=$pageposts[0]->tripadvisor_score;
			$wlan=$pageposts[0]->wlan;
			$holidaycheck_score=$pageposts[0]->holidaycheck_score;
			$notes=$pageposts[0]->notes;
			$request_budget=$pageposts[0]->request_budget;
			$currency=$pageposts[0]->currency;
			$unit_type=$pageposts[0]->unit_type;
			$confirm_updates=$pageposts[0]->confirm_updates;
	 		?>
 			<div class="requestContent" data-track-c="trip finder">
  <div class="requestPage-headsection">
    <ul class="breadcrumbs">
      <li><a href="<?php echo  site_url(); ?>/travels">Travel Questions</a></li>
      <li><a href="<?php echo  site_url(); ?>/travels">Travels</a></li>
      <li class="active"><?php echo substr($post_title,0,17); ?>...</li>
    </ul>
    <a href="<?php echo  site_url(); ?>" data-track-click="new request button" data-track-l="location: request page" class="button button--sLnk button--p button--s requestPage-button">Make an inquiry</a> </div>
  <div class="requestContent-w">
    <div class="requestContent-r">
      <div class="requestContent-m">
        <article class="singleRequest w--1">
          <div class="singleRequest-userpic">
          <img src="<?php echo $imgURL; ?>"  alt="login image"/></div>
          <div class="singleRequest-main">
            <div class="singleRequest-main-subsection">
              <header class="singleRequest-header">
                <div class="singleRequest-meta-wrapper">
                  <p class="singleRequest-user-details">
                  <span class="request-user-name"><?php echo $user_login; ?></span> published <?php  echo time_elapsed_string(strtotime($post_modified)); ?> </p>
                  <h1 class="request-headline"><?php echo $post_title;?></h1>
                  <div class="request-meta">
                    <time class="request-date-range"><?php echo date('d F Y', strtotime($earliest_at))." - ".date('d F Y', strtotime($latest_at)); ?></time>
                    <span class="request-people"><?php echo $number_of_adults."adult and ".$number_of_kids." children"; 
                    if($number_of_kids>0)
                    	echo "(".$request_people_alterKind.")";
                    ?></span> </div>
                </div>
                <div class="singleRequest-budget-section">
                  <p>My budget is</p>
                  <p class="request-budget"><?php echo $request_budget; ?>&euro;</p>
                  <p class="request-unit-type"><?php echo $unit_type; ?></p>
                </div>
              </header>
              <div class="singleRequest-content"><!-- travel package -->
                <div class="request-package-duration">
                	<?php
                	if($travel_item==3)
                	{
                		if($requiresItem==1)
			            {
			                $requiresItemHtml='One Way';
			            }
			            else if($requiresItem==2)
			            {
			                $requiresItemHtml='Return';
			            }
			            else if($requiresItem==3)
			            {
			                $requiresItemHtml='Gabelflug';
			            }
			            echo $requiresItemHtml."(".$clas.")";
                	}
                	else
                	{
                    echo $duration_from." ".$duration_unit." in";
                    }

                	?>
                </div>
                <div class="request-location">
                <?php
                if($travel_item==1)
			    {
			        echo '<a href="#" class="request-location-link" data-track-click="request destination" data-track-l="Sydney">'.$number_of_wantGo.'</a></div>
                	<div class="request-package-from">From '.$number_of_departure.'</div>
                	<div class="request-package-from">Except '.$number_of_except.'</div>';
			    }
			    else if($travel_item==2)
			    {

			        echo '<a href="#" class="request-location-link" data-track-click="request destination" data-track-l="Sydney">'.$number_of_wantGo.'</a></div>
                	<div class="request-package-from">Except '.$number_of_except.'</div>';
			    }
			    else if($travel_item==3)
			    {
			    	if($requiresItem==1)
			        {
			            echo '<a href="#" class="request-location-link" data-track-click="request destination" data-track-l="Sydney">'.$departure.' --> '.$destination.'</a></div>';
			        }
			        else if($requiresItem==2)
			        {
			            echo '<a href="#" class="request-location-link" data-track-click="request destination" data-track-l="Sydney">'.$departure_arrival.' --> '.$destination_e.'</a></div>';
			        }
			        else if($requiresItem==3)
			        {
			            echo '<a href="#" class="request-location-link" data-track-click="request destination" data-track-l="Sydney">'.$departure.' --> '.$destination_e_stops.' --> '.$ultimate_goal_return_location.'</a></div>';
			        }

			    }
                ?>
                <!-- <a href="#" class="request-location-link" data-track-click="request destination" data-track-l="Sydney">Sydney</a></div>
                <div class="request-package-from">Von Delhi</div>
                <div class="request-package-from">Ausgenommen Mumbai</div> -->


                
                <?php
                if($travel_item==3)
                {
                	echo '<div class="request-flight-details">';
                }
                else
                {
                	echo '<div class="request-package-type">';
                }
                if($travel_item==1)
                echo 'Hotel price range: '.$price_level;
                else if($travel_item==2)
                echo $accommodation_type;
            	else if($travel_item==3)
            	echo $airline_type;
                ?>
                </div>
                <div class="request-details">
                  <ul>
                    <?php
                if($travel_item==3)
                {
                	if($railfly=='true')
                	echo '<li>I want to use Rail & Fly.</li>';
                    if($nearby_airports=='true')
                	echo '<li>Area Airports are ok.</li>';
                	if($multistops=='true')
                	echo '<li>Stopovers are ok, if it saves money.</li>';
                	if($collect_miles=='true')
                	echo '<li>I collect miles.</li>';
                }
                else
                {
                echo '<li>'.$board.'</li>
                    <li>Close to:
                      <p>'.$notes.'</p>';
                if($travel_item==2)
                {
                	if($minimum_category==0)
                	{
                		echo '<p>I do not care</p>';                		
                	}
                	else
                	{
                		echo '<p>At least '.$minimum_category.' stars</p>';
                	}

        		}
        		
                    echo '</li>
                    <li>';
                    if($travel_item!=2)
                    {
                    	echo "Min. HolidayCheck Recommendation:".$holidaycheck_score."%";
                    }
                    else
                    {
                    	echo "<p>TripAdvisor Minimum: ".($tripadvisor_score/10)."points</p>";
                    	if($wlan!="")
                    	{
                    		echo "<p>With Wi-Fi</p>";
                    	}
                    }
                    echo '</li>';
                }
                    ?>                    
                  </ul>
                </div>
                <!-- accommodation --> 
                <!-- flight -->
                <div class="request-description"></div>
                <div class="request-details" style="margin-top:-47px">
                  <p><?php echo $post_content;?></p>
                </div>
              </div>
              <p class="request-buttons"> 
              <a data-track-click="write proposal button" data-track-l="location: request item" data-request-offer class="button button--act button--request" data-commentable-type="SixMinutes\Pirateship\TravelRequest" data-commentable-id="26977">Deal suggest </a> 
              <a data-track-click="comment on request button" data-track-l="location: request item" data-request-comment class="button button--act button--request" data-commentable-type="SixMinutes\Pirateship\TravelRequest" data-commentable-id="26977">Comment</a> </p>
            </div>


<?php

		$commentQuerystr = "SELECT $wpdb->comments.* FROM $wpdb->comments WHERE $wpdb->comments.comment_post_ID = $post_id and $wpdb->comments.comment_approved=1";
		
		//echo $commentQuerystr; 
		
		$pagepostsComment = $wpdb->get_results($commentQuerystr, OBJECT);


if(count($pagepostsComment)>0)
{
	echo '<section data-track-l="location: request page comments" id="comments" class="sect sect--request">
  <div class="comments">
    <h2 class="comments-hl">'.count($pagepostsComment).' comment</h2>';
	for($i=0;$i<count($pagepostsComment);$i++)
	{
		$comment_image_url=get_cupp_meta($pagepostsComment[$i]->user_id, $size);
        if($comment_image_url=='')
        {
        	$comment_image_url = get_template_directory_uri().'/img/default_avatar.png';
        }
        $user_info = get_userdata($pagepostsComment[$i]->user_id);

		echo '<ul class="comments-lst">
      <li id="c-68808" class="comments-it"><img alt="WeLoveToTravel8" src="'.$comment_image_url.'" class="comments-avt">
        <div class="comments-bd">
          <div class="comments-hd">
            <time datetime="2015-01-03" class="comments-dt"> '.date('F j, Y, g:i a', strtotime($pagepostsComment[$i]->comment_date)).'</time>
            <p class="comments-a"><span class="comments-a-n">'.$user_info->user_login.'</span> says:</p>
          </div>
          <div class="comments-ct">
            '.$pagepostsComment[$i]->comment_content.'
          </div>
          <div class="comments-ft"> 
          <a data-reply-to="68808" data-remote="#" data-track-c="comments" data-track-click="answer to comment">Reply</a> </div>
        </div>';
	}
	for($i=1;$i<=count($pagepostsComment);$i++)
	{
		echo '</li>
            </ul>';
	}
    echo '</div></section>';
}
?>




            <section class="sect sect--request" id="comments" data-track-l="location: request page comments"> </section>
            <section class="sect sect--request">
              <div id="tab-container" class="tab-container">
                <ul class='etabs'>
                  <li class='tab'>
                  <a data-track-click="write proposal tab" data-track-l="location: request page" href="#tabs1-response">Suggest Deal</a></li>
                  <li class='tab'>
                  <a data-track-click="comment on request tab" data-track-l="location: request page" href="#tabs1-comment">Comment on</a></li>
                </ul>
                <div id="tabs1-response">
                  <div id="response-form">


                  	<ul class="form-lst">
                        <li class="form-row"> <span class="respond-lb"></span>
                          <div class="form-ct">
                            <div class="respond-hd">
        <?php
        if ( is_user_logged_in() ) 
        {
        	$login_image_url=get_cupp_meta($current_user->ID, $size);
	        if($login_image_url=='')
	        {
	        	$login_image_url = get_template_directory_uri().'/img/default_avatar.png';
	        }
	         echo '<img class="respond-avt" src="'.$login_image_url.'">
	          <div class="respond-bd">
	            <p> <strong class="respond-nfo">Hello '.$current_user->display_name.'!</strong>                              
	          </div>';
        }
                            
      echo '<div class="contentBox-section">
      <div class="clr"></div>
      
         <div class="login-register-span main_col" >';
        
          if ( !is_user_logged_in() ) {
        echo '<span style="text-decoration: underline; cursor:pointer;" onclick="loginClick()" class="color_text">I must still register</span>
        <span style="text-decoration: underline; cursor:pointer;" class="display-none color_text" onclick="registerClick()">I already have an account        </span>';            
          }
        
        echo '<div class="clar"></div>
         <div class="clar"></div>
        </div>
        <div class="clr"></div>
        <div class="main_col">
         <div class="clar"></div>
         <div class="user-login">'.do_shortcode( "[wppb-login]" ).'</div>
         <div class="user-register display-none">'.do_shortcode( "[wppb-register]" ).'</div>
         <div class="clr"></div>
        </div>
        <div class="clr"></div>
     </div>';       
     ?>
                            </div>
                          </div>
                        </li>
                    </ul>



                    <form method="POST" action="#" accept-charset="UTF-8" class="form" id="travel_response_form" data-loggedin="1" data-track-submit="submit proposal button" data-track-l="request page">
                      <input name="_token" type="hidden" value="JNxcW4InZtlXR3rYd0ZjCObX6aV5KRyXEsfqheiA">
                      <ul class="form-lst">
                        <!--<li class="form-row"> <span class="respond-lb"></span>
                          <div class="form-ct">
                            <div class="respond-hd"> 
                             <img class='respond-avt' src="<?php echo get_template_directory_uri(); ?>/img/default_avatar.png">
                              <div class="respond-bd">
                                <p> <strong class="respond-nfo">Hallo santu!</strong> 
                                <a class="respond-logout" href="#" data-track-click="logout">Abmelden</a> </p>
                                <p class="respond-fb"> Melde dich mit deinem Facebook-Konto an, um deine Kommentare zu teilen.<br/>
                         <a rel="nofollow" class="respond-fbBt" href="http://www.urlaubspiraten.de/user/social/provider/facebook" data-track-click="fb connect button"><span class="fbCnBt-ico"></span><span class="fbCnBt-txt">Mit Facebook anmelden</span></a> </p>
                              </div> -->
                              <?php
     //  echo '<div class="contentBox-section">
     //  <div class="clr"></div>
      
     //     <div class="login-register-span main_col" >';
        
     //      if ( !is_user_logged_in() ) {
     //    echo '<span style="text-decoration: underline; cursor:pointer;" onclick="loginClick()" class="color_text">I must still register</span>
     //    <span style="text-decoration: underline; cursor:pointer;" class="display-none color_text" onclick="registerClick()">I already have an account        </span>';            
     //      }
        
     //    echo '<div class="clar"></div>
     //     <div class="clar"></div>
     //    </div>
     //    <div class="clr"></div>
     //    <div class="main_col">
     //     <div class="clar"></div>
     //     <div class="user-login">'.do_shortcode( "[wppb-login]" ).'</div>
     //     <div class="user-register display-none">'.do_shortcode( "[wppb-register]" ).'</div>
     //     <div class="clr"></div>
     //    </div>
     //    <div class="clr"></div>
     // </div>';       
     ?>
                            <!-- </div>
                          </div>
                        </li> -->
                        <li class="form-row">
                          <label for="title" class="form-lb">Title</label>
                          <div class="form-ct">
                            <input class="input" required placeholder="z.B. Luxus-Urlaub auf den Malediven" name="title" type="text" id="title">
                          </div>
                        </li>
                        <li class="form-row">
                          <label for="starts_at" class="form-lb">Period of travel</label>
                          <div class="form-ct">
                            <input class="input input--half" data-date-format="dd-mm-yyyy" data-start-date="data-start-date" placeholder="von" id="starts_at" required name="starts_at" type="text">
                            <input class="input input--half" data-date-format="dd-mm-yyyy" data-end-date="data-end-date" placeholder="bis" id="ends_at" required name="ends_at" type="text">
                          </div>
                        </li>
                        <li class="form-row">
                          <div class="form-lb"></div>
                          <div class="form-ct">
                            <div class="request-form-separator"></div>
                          </div>
                        </li>
                        <li class="form-row">
                          <label for="type" class="form-lb">Type of trip</label>
                          <div class="form-ct response-type">
                            <div class="response-type-item">
                              <input required name="carrier_type" type="radio" value="flight">
                               Flight</div>
                            <div class="response-type-item">
                              <input required name="carrier_type" type="radio" value="bus">
                               Bus ride</div>
                            <div class="response-type-item">
                              <input required name="carrier_type" type="radio" value="train">
                               Train</div>
                          </div>
                        </li>
                        <div class="flight-panel transport-fields" style="display: none" > 
                          <!-- include flight-specific fields-->
                          <li class="form-row">
                            <label for="flight_route_carrier_name" class="form-lb transport-lb">Airline(s)</label>
                            <div class="form-ct">
                              <input class="input transport-lb" placeholder="z.B. Lufthansa, Air Berlin etc." name="flight_route_carrier_name" type="text" id="flight_route_carrier_name">
                            </div>
                          </li>
                          <li class="form-row">
                            <label for="flight_route_class" class="form-lb">Class seat</label>
                            <div class="form-ct">
                              <select id="flight_route_class" name="flight_route_class">
                                <option value="economy_class">Economy Class</option>
                                <option value="business_class">Business Class</option>
                                <option value="first_class">First Class</option>
                              </select>
                            </div>
                          </li>
                          <li class="form-row">
                            <label for="flight_route_type" class="form-lb transport-lb">Flight Type</label>
                            <div class="form-ct">
                              <select id="flight_route_type" name="flight_route_type">
                                <option value="flight_route_type_custom">Einfacher Flug</option>
                                <option value="flight_route_type_circle_trip">Hin- und R&uuml;ckflug</option>
                                <option value="flight_route_type_origin_open_jaw">Gabelflug</option>
                              </select>
                            </div>
                          </li>
                          <li class="form-row flight-row">
                            <label for="flight_route_origin" class="form-lb">Departure</label>
                            <div class="form-ct">
                              <input location-select="location-select" data-multiselect="1" name="flight_route_origin" type="text" id="flight_route_origin">
                            </div>
                          </li>
                          <li class="form-row flight-row">
                            <label for="flight_route_destination" class="form-lb">Destination</label>
                            <div class="form-ct">
                              <input location-select="location-select" data-multiselect="1" name="flight_route_destination" type="text" id="flight_route_destination">
                            </div>
                          </li>
                          <script type="text/html" id="flight_route_type_custom">
    <li class="form-row flight-row">
        <label for="flight_route_origin" class="form-lb transport-lb">Departure</label>        <div class="form-ct">
            <input location-select="location-select" data-multiselect="1" name="flight_route_origin" type="text" id="flight_route_origin">        </div>
    </li>
    <li class="form-row flight-row">
        <label for="flight_route_destination" class="form-lb transport-lb">Destination</label>        <div class="form-ct">
            <input location-select="location-select" data-multiselect="1" name="flight_route_destination" type="text" id="flight_route_destination">        </div>
    </li>
</script> 
                          <script type="text/html" id="flight_route_type_circle_trip">
    <li class="form-row flight-row">
        <label for="flight_route_origin" class="form-lb transport-lb">Abflug- / Ankunfts-Ort</label>        <div class="form-ct">
            <input location-select="location-select" data-multiselect="1" name="flight_route_origin" type="text" id="flight_route_origin">        </div>
    </li>
    <li class="form-row flight-row">
        <label for="flight_route_stops" class="form-lb transport-lb">Reiseziel/e</label>        <div class="form-ct">
            <input location-select="location-select" data-multiselect="1" name="flight_route_stops" type="text" id="flight_route_stops">        </div>
    </li>
</script> 
                          <script type="text/html" id="flight_route_type_origin_open_jaw">
    <li class="form-row flight-row">
        <label for="flight_route_origin" class="form-lb transport-lb">Departure</label>        <div class="form-ct">
            <input location-select="location-select" data-multiselect="1" name="flight_route_origin" type="text" id="flight_route_origin">        </div>
    </li>
    <li class="form-row flight-row">
        <label for="flight_route_stops" class="form-lb transport-lb">Reiseziel/e oder Stopps</label>        <div class="form-ct">
            <input location-select="location-select" data-multiselect="1" name="flight_route_stops" type="text" id="flight_route_stops">        </div>
    </li>
    <li class="form-row flight-row">
        <label for="flight_route_destination" class="form-lb transport-lb">Letztes Ziel / R&uuml;ckkehrort</label>        <div class="form-ct">
            <input location-select="location-select" data-multiselect="1" name="flight_route_destination" type="text" id="flight_route_destination">        </div>
    </li>
</script> </div>
                        <div class="bus-panel transport-fields" style="display: none"> 
                          <!-- include bus-specific fields-->
                          <li class="form-row">
                            <label for="bus_route_carrier_name" class="form-lb transport-lb">Bus companies</label>
                            <div class="form-ct">
                              <input class="input transport-lb" placeholder="z.B. Berlin Linien Bus" name="bus_route_carrier_name" type="text" id="bus_route_carrier_name">
                            </div>
                          </li>
                          <li class="form-row">
                            <label for="bus_route_type" class="form-lb transport-lb">Route</label>
                            <div class="form-ct">
                              <select id="bus_route_type" name="bus_route_type">
                                <option value="bus_route_type_custom">Einfache Fahrt</option>
                                <option value="bus_route_type_circle_trip">Hin- und R&uuml;ckfahrt</option>
                              </select>
                            </div>
                          </li>
                          <li class="form-row flight-row">
                            <label for="bus_route_origin" class="form-lb">Departure</label>
                            <div class="form-ct">
                              <input location-select="location-select" data-multiselect="1" name="bus_route_origin" type="text" id="bus_route_origin">
                            </div>
                          </li>
                          <li class="form-row flight-row">
                            <label for="bus_route_destination" class="form-lb">Destination</label>
                            <div class="form-ct">
                              <input location-select="location-select" data-multiselect="1" name="bus_route_destination" type="text" id="bus_route_destination">
                            </div>
                          </li>
                          <script type="text/html" id="bus_route_type_custom">
    <li class="form-row flight-row">
        <label for="bus_route_origin" class="form-lb transport-lb">Departure</label>        <div class="form-ct">
            <input location-select="location-select" data-multiselect="1" name="bus_route_origin" type="text" id="bus_route_origin">        </div>
    </li>
    <li class="form-row flight-row">
        <label for="bus_route_destination" class="form-lb transport-lb">Destination</label>        <div class="form-ct">
            <input location-select="location-select" data-multiselect="1" name="bus_route_destination" type="text" id="bus_route_destination">        </div>
    </li>
</script> 
                          <script type="text/html" id="bus_route_type_circle_trip">
    <li class="form-row flight-row">
        <label for="bus_route_origin" class="form-lb transport-lb">Abreise- / R&uuml;ckreise-Ort</label>        <div class="form-ct">
            <input location-select="location-select" data-multiselect="1" name="bus_route_origin" type="text" id="bus_route_origin">        </div>
    </li>
    <li class="form-row flight-row">
        <label for="bus_route_stops" class="form-lb transport-lb">Reiseziel/e</label>        <div class="form-ct">
            <input location-select="location-select" data-multiselect="1" name="bus_route_stops" type="text" id="bus_route_stops">        </div>
    </li>
</script> </div>
                        <div class="train-panel transport-fields" style="display: none"> 
                          <!-- include train-specific fields-->
                          <li class="form-row">
                            <label for="train_route_carrier_name" class="form-lb transport-lb">Bahn-Gesellschaft(en)</label>
                            <div class="form-ct">
                              <input class="input transport-lb" placeholder="z.B. Deutsche Bahn" name="train_route_carrier_name" type="text" id="train_route_carrier_name">
                            </div>
                          </li>
                          <li class="form-row">
                            <label for="train_route_type" class="form-lb transport-lb">Route</label>
                            <div class="form-ct">
                              <select id="train_route_type" name="train_route_type">
                                <option value="train_route_type_custom">Einfache Fahrt</option>
                                <option value="train_route_type_circle_trip">Hin- und R&uuml;ckfahrt</option>
                              </select>
                            </div>
                          </li>
                          <li class="form-row flight-row">
                            <label for="train_route_origin" class="form-lb">Departure</label>
                            <div class="form-ct">
                              <input location-select="location-select" data-multiselect="1" name="train_route_origin" type="text" id="train_route_origin">
                            </div>
                          </li>
                          <li class="form-row flight-row">
                            <label for="train_route_destination" class="form-lb">Destination</label>
                            <div class="form-ct">
                              <input location-select="location-select" data-multiselect="1" name="train_route_destination" type="text" id="train_route_destination">
                            </div>
                          </li>
                          <script type="text/html" id="train_route_type_custom">
    <li class="form-row flight-row">
        <label for="train_route_origin" class="form-lb transport-lb">Departure</label>        <div class="form-ct">
            <input location-select="location-select" data-multiselect="1" name="train_route_origin" type="text" id="train_route_origin">        </div>
    </li>
    <li class="form-row flight-row">
        <label for="train_route_destination" class="form-lb transport-lb">Destination</label>        <div class="form-ct">
            <input location-select="location-select" data-multiselect="1" name="train_route_destination" type="text" id="train_route_destination">        </div>
    </li>
</script> 
                          <script type="text/html" id="train_route_type_circle_trip">
    <li class="form-row flight-row">
        <label for="train_route_origin" class="form-lb transport-lb">Abreise- / R&uuml;ckreise-Ort</label>        <div class="form-ct">
            <input location-select="location-select" data-multiselect="1" name="train_route_origin" type="text" id="train_route_origin">        </div>
    </li>
    <li class="form-row flight-row">
        <label for="train_route_stops" class="form-lb transport-lb">Reiseziel/e</label>        <div class="form-ct">
            <input location-select="location-select" data-multiselect="1" name="train_route_stops" type="text" id="train_route_stops">        </div>
    </li>
</script>
                          <li class="form-row train-discount-box">
                            <label for="discount" class="form-lb">Erm&auml;&szlig;igter Preis</label>
                            <div class="form-ct response-type">
                              <input name="has_train_discount" type="checkbox">
                            </div>
                          </li>
                          <div id="discount-details" style="display: none">
                            <li class="form-row">
                              <label for="discount_name" class="form-lb">Rabatt-Programm</label>
                              <div class="form-ct">
                                <input class="input" placeholder="z.B. BahnCard 25" name="discount_name" type="text" id="discount_name">
                              </div>
                            </li>
                            <li class="form-row">
                              <label for="discount_percentage" class="form-lb">Erm&auml;&szlig;igung</label>
                              <div class="form-ct">
                                <input id="discount_percentage" type="number" name="discount_percentage" placeholder="0" class="input"/>
                                <span class="form-nfoI form-nfoI--b">% (nur Prozente angeben)</span> </div>
                            </li>
                          </div>
                        </div>
                        <li class="form-row">
                          <div class="form-lb"></div>
                          <div class="form-ct">
                            <div class="request-form-separator"></div>
                          </div>
                        </li>
                        <li class="form-row">
                          <label for="accommodation" class="form-lb">Accommodation</label>
                          <div class="form-ct response-type">
                            <div class="accommodation-type-item">
                              <input required name="accommodation_type" type="radio" value="hotels">
                              Hotel</div>
                            <div class="accommodation-type-item">
                              <input required name="accommodation_type" type="radio" value="apartments">
                                Hostels / Apartment</div>
                          </div>
                        </li>
                        <div id="accommodation" class="accommodation-fields hide--d"> 
                          <!-- include common accommodation fields -->
                          <li class="form-row">
                            <label for="accommodation_name" class="form-lb">Property name</label>
                            <div class="form-ct">
                              <input class="input" required placeholder="z.B. Hotel Adlon" name="accommodation_name" type="text" id="accommodation_name">
                            </div>
                          </li>
                          <li class="form-row">
                            <label for="category" class="form-lb">Hotel Class</label>
                            <div class="form-ct">
                              <select id="category" name="category">
                                <option value="1">1 Stern</option>
                                <option value="1.5">1.5 Sterne</option>
                                <option value="2">2 Sterne</option>
                                <option value="2.5">2.5 Sterne</option>
                                <option value="3">3 Sterne</option>
                                <option value="3.5">3.5 Sterne</option>
                                <option value="4">4 Sterne</option>
                                <option value="4.5">4.5 Sterne</option>
                                <option value="5">5 Sterne</option>
                                <option value="5.5">5.5 Sterne</option>
                              </select>
                            </div>
                          </li>
                          <li class="form-row">
                            <label for="board" class="form-lb">Catering</label>
                            <div class="form-ct">
                              <select id="board" name="board">
                                <option value="without">Ohne Catering</option>
                                <option value="breakfast_only">Nur Fr&uuml;hst&uuml;ck</option>
                                <option value="half_board">Halbpension</option>
                                <option value="full_board">Vollpension</option>
                                <option value="all_inclusive">Alles inklusive</option>
                              </select>
                            </div>
                          </li>
                          <li class="form-row">
                            <label for="wlan" class="form-lb">WLAN</label>
                            <div class="form-ct">
                              <input checked="checked" name="wlan" type="checkbox" value="1" id="wlan">
                            </div>
                          </li>
                          <li class="form-row">
                            <label for="location" class="form-lb">Ort</label>
                            <div class="form-ct">
                              <input location-select="location-select" name="location" type="text" id="location">
                            </div>
                          </li>
                          <li class="form-row">
                            <label for="holidaycheck_url" class="form-lb">HolidayCheck-Link</label>
                            <div class="form-ct">
                              <input class="input" placeholder="http://" name="holidaycheck_url" type="text" id="holidaycheck_url">
                            </div>
                          </li>
                          <li class="form-row">
                            <label for="holidaycheck_score" class="form-lb">HolidayCheck recommendation rate</label>
                            <div class="form-ct">
                              <input id="holidaycheck_score" type="number" name="holidaycheck_score" placeholder="z.B. 91" class="input"/>
                              <span class="form-nfoI form-nfoI--b">%</span> </div>
                          </li>
                        </div>
                        <li class="form-row">
                          <div class="form-lb"></div>
                          <div class="form-ct">
                            <div class="request-form-separator"></div>
                          </div>
                        </li>
                        <li class="form-row">
                          <label for="booking_type" class="form-lb">Ticketing</label>
                          <div class="form-ct response-type">
                            <div class="accommodation-type-item">
                              <input checked="checked" name="booking_type" type="radio" value="all-in-one" id="booking_type">
                               Complete package</div>
                            <div class="accommodation-type-item">
                              <input name="booking_type" type="radio" value="separate" id="booking_type">
                               separate bookings</div>
                          </div>
                        </li>
                        <li class="form-row">
                          <label for="deal_url" class="form-lb" data-alt-name="Buchungs-Link: Anreise" data-ini-name="Buchungs-Link">Booking link</label>
                          <div class="form-ct">
                            <input class="input" placeholder="http://" required name="deal_url" type="text" id="deal_url">
                          </div>
                        </li>
                        <li class="form-row" id="hotel-deal-item" style="display: none">
                          <label for="hotel_deal_url" class="form-lb" data-alt-name="Buchungs-Link: Unterkunft">Buchungs-Link</label>
                          <div class="form-ct">
                            <input class="input" placeholder="Nur wenn Unterkunft extra gebucht werden muss" name="hotel_deal_url" type="text" id="hotel_deal_url">
                          </div>
                        </li>
                        <li class="form-row">
                          <label for="price" class="form-lb">Price</label>
                          <div class="form-ct">
                            <input class="input input--half" placeholder="0" required name="price" type="text" id="price">
                            <span class="form-nfoI form-nfoI--b price-label-holder">EUR (&euro;) per person</span> </div>
                        </li>
                        <li class="form-row">
                          <div class="form-lb"></div>
                          <div class="form-ct">
                            <div class="request-form-separator"></div>
                          </div>
                        </li>
                        <li class="form-row">
                          <label for="description" class="form-lb">Comments</label>
                          <div class="form-ct">
                            <textarea class="input" placeholder="Hier ist Platz f&uuml;r eine kurze Zusammenfassung, Anmerkungen und sonstigen Hinweisen zu Flug, Unterkunft oder auch dem Reiseziel." name="description" cols="50" rows="10" id="description"></textarea>
                          </div>
                        </li>
                        <li class="form-row"> <span class="form-lb"></span>
                          <div class="form-ct">
                          <?php
                          if ( is_user_logged_in() ) {
			              echo '<input class="button button--pAct" type="submit" value="Deal Send us your suggestion">';
				          } 
				          else 
				          {
				          	echo '<input disabled="disabled" class="button button--pAct" type="submit" value="Deal Send us your suggestion">';	
				          }
			          ?>    
                          </div>
                        </li>
                      </ul>
                    </form>
                  </div>
                </div>
                <div id="tabs1-comment">
                  <div class="sect respond" id="respond">
                    <div class="sect-ct">

                    <ul class="form-lst">
                        <li class="form-row"> <span class="respond-lb"></span>
                          <div class="form-ct">
                            <div class="respond-hd">
        <?php
        if ( is_user_logged_in() ) 
        {
        	$login_image_url=get_cupp_meta($current_user->ID, $size);
	        if($login_image_url=='')
	        {
	        	$login_image_url = get_template_directory_uri().'/img/default_avatar.png';
	        }
	         echo '<img class="respond-avt" src="'.$login_image_url.'">
	          <div class="respond-bd">
	            <p> <strong class="respond-nfo">Hallo '.$current_user->display_name.'!</strong>                              
	          </div>';
        }
                            
      echo '<div class="contentBox-section">
      <div class="clr"></div>
      
         <div class="login-register-span main_col" >';
        
          if ( !is_user_logged_in() ) {
        echo '<span style="text-decoration: underline; cursor:pointer;" onclick="loginClick()" class="color_text">I must still register</span>
        <span style="text-decoration: underline; cursor:pointer;" class="display-none color_text" onclick="registerClick()">I already have an account        </span>';            
          }
        
        echo '<div class="clar"></div>
         <div class="clar"></div>
        </div>
        <div class="clr"></div>
        <div class="main_col">
         <div class="clar"></div>
         <div class="user-login">'.do_shortcode( "[wppb-login]" ).'</div>
         <div class="user-register display-none">'.do_shortcode( "[wppb-register]" ).'</div>
         <div class="clr"></div>
        </div>
        <div class="clr"></div>
     </div>';       
     ?>
                            </div>
                          </div>
                        </li>
                    </ul>
                      <!-- <form method="POST" action="" ng-submit="commentForm()" ng-controller="DealComment" accept-charset="UTF-8" id="comment_form" class="form"> -->
                      <form method="POST" accept-charset="UTF-8" class="form">  
                        <input name="post_id" type="hidden" value="<?php echo $post_id; ?>">
                        <input name="post_comment_id" type="hidden" value="<?php echo $user_ID; ?>">
                        <ul class="form-lst">
                          <!-- <li class="form-row"> <span class="respond-lb"></span>
                            <div class="form-ct">
                              <div class="respond-hd"> <img class='respond-avt' src="<?php echo get_template_directory_uri(); ?>/img/default_avatar.png">
                                <div class="respond-bd">
                                  <p> <strong class="respond-nfo">Hallo santu!</strong> <a class="respond-logout" href="#" data-track-click="logout">Abmelden</a> </p>
                                  <p class="respond-fb"> Log in with your Facebook account to share your comments.<br/>
                                    <a rel="nofollow" class="respond-fbBt" href="#" data-track-click="fb connect button"><span class="fbCnBt-ico"></span><span class="fbCnBt-txt">Mit Facebook anmelden</span></a> </p>
                                </div>
                              </div>
                            </div>
                          </li> -->
                          <li class="hide--d">
                            <label for="content" class="respond-lb">Antwort auf</label>
                            <span class="form-ct">
                            <div contenteditable="true" id="reply-blockquote"></div>
                            </span> 
                          </li>
                          <li class="form-row" id="comment_form">
                            <label for="content" class="respond-lb">Your Comment</label>
                            <span class="form-ct">
                            <textarea class="input" rows="5" name="content" cols="50" id="content" required></textarea>
                            </span> </li>
                          <li class="form-row"> <span class="respond-lb"></span> <span class="form-ct">
                        <?php
          if ( is_user_logged_in() ) {
            echo '<input class="button button--pAct" type="submit" value="Send Comment" name="comment_submit" formaction="">';
          } 
          else 
          {
          	echo '<input disabled="disabled" class="button button--pAct" type="submit" value="Send Comment">';
          }
          ?>  
                            </span> </li>
                        </ul>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </section>
          </div>
        </article>
      </div>
    </div>
  </div>
</div>

<p class="copyright">©2014 Urlaubspiraten</p>
  <script id="modalConfirmTpl" type="text/html">
        <div class="modalWin-editor">
            <div>[CONTENT]</div>
            <p class="fGrid">
                <input type="button" class="button button--act fGrid-l" value="Abbrechen"/>
                <input type="button" class="button button--pAct fGrid-r confirm-accept" value="Ja"/>
            </p>
        </div>
    </script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery-1.11.0.min.js"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/js/base.js"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/js/front.js"></script> 
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/redactor.min.js?v=1.4.4"></script> 
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/editor.js"></script> 
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/comment_main.js?v=1.02"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap.min.js"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap-datepicker.js"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/js/date-picker.js?v=1.1"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/js/select2.js?v=3.4.5"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/js/select2_locale_de.js"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.hashchange.min.js"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.easytabs.min.js"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/js/response.js?v=1.01"></script>

<script src="<?php echo get_template_directory_uri(); ?>/js/look_at_deal.js"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/js/browser_front.js"></script>
			
		</div><!-- #content -->
	</div><!-- #primary -->
</div><!-- #main-content -->
<?php
function time_elapsed_string($ptime)
{
    $etime = time() - $ptime;

    if ($etime < 1)
    {
        return '0 seconds';
    }

    $a = array( 365 * 24 * 60 * 60  =>  'year',
                 30 * 24 * 60 * 60  =>  'month',
                      24 * 60 * 60  =>  'day',
                           60 * 60  =>  'hour',
                                60  =>  'minute',
                                 1  =>  'second'
                );
    $a_plural = array( 'year'   => 'years',
                       'month'  => 'months',
                       'day'    => 'days',
                       'hour'   => 'hours',
                       'minute' => 'minutes',
                       'second' => 'seconds'
                );

    foreach ($a as $secs => $str)
    {
        $d = $etime / $secs;
        if ($d >= 1)
        {
            $r = round($d);
            return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
        }
    }
}
?>

<?php
get_sidebar();
get_footer();