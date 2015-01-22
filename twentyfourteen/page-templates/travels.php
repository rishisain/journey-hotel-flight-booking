<?php
/**
 * Template Name: Travels Page
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
global $wpdb;
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
      $selectposts = $wpdb->get_results("select wp_posts.ID from wp_posts where wp_posts.post_status = 'publish' AND wp_posts.post_type='post'", OBJECT);
?>
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">			
<div class="requestContent" data-track-c="trip finder">
  <div class="requestPage-headsection">
    <h1 class="requestPage-headline">Short breaks and (package) Travel</h1>
    <a href="<?php echo  site_url(); ?>" data-track-click="new request button" data-track-l="location: request listing"
           class="button button--sLnk button--p button--s requestPage-button">Make an inquiry</a> </div>
  <div class="requestContent-w">
    <div class="requestContent-r">
      <div class="requestContent-m">
        <div class="iGrid iGrid--c requestSorting">
          <div class="w--1-3 iGrid-it new_w_grid"><?php echo count($selectposts); ?> requests found </div>
          <div class="w--2-3 iGrid-it requestSorting-params">
           <span>Sort by: 
           <a href="#" class="fa dropdown-anchor" data-dropdown="#sortby-dropdown"> Latest activity  </a> </span> </div>
          <div class="clr"></div>
        </div>

        <?php
      for($i=0;$i<count($selectposts);$i++)
      {
        $post_id = $selectposts[$i]->ID;
        $querystr = "SELECT $wpdb->posts.post_title,$wpdb->posts.post_content,$wpdb->posts.post_modified, $wpdb->posts.post_author,$wpdb->users.user_login,".$wpdb->prefix.'deal_posts'.".* FROM $wpdb->posts, ".$wpdb->prefix.'deal_posts'.",wp_users
        WHERE $wpdb->users.ID=$wpdb->posts.post_author AND ".$wpdb->prefix.'deal_posts'.".post_id = $wpdb->posts.ID 
        AND $wpdb->posts.ID = $post_id";

      //echo $querystr."<br>";
      $pageposts = $wpdb->get_results($querystr, OBJECT);
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
      
      if($travel_item==3)
      {
        $request_tab_icon='request--fl';
      }
      else
      {
        $request_tab_icon='request--tr';
      }
      echo '<article class="request w--1 '.$request_tab_icon.'">
          <div class="request-main w--3-4">
            <header class="request-main-header"> <a class="request-cat" href="#">$request->type->name</a> <a data-track-click="request title" data-track-l="location: request listing" href="#">
              <h2 class="request-headline">'.$post_title.'</h2>
              </a>
              <div class="request-meta">
                <time class="request-date-range">'.date("d F Y", strtotime($earliest_at)).' - '.date("d F Y", strtotime($latest_at)).'</time>
                <span class="request-people">';
                echo $number_of_adults."adult and ".$number_of_kids." children"; 
                    if($number_of_kids>0)
                      echo "(".$request_people_alterKind.")";
                echo '</span> </div>
            </header>
            <div class="request-main-content"><!-- travel package -->
              <div class="request-package-duration">';

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

              echo '</div>
              <div class="request-location">';
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
              // <a href="#" class="request-location-link" data-track-click="request destination" data-track-l="Lesbos">Lesbos</a></div>
              // <div class="request-package-from">Von Paderborn</div>
              // <div class="request-package-from"> </div>
               //echo '<div class="request-package-type">Hotel price range: '.$price_level.'</div>
              //<div class="request-details">Min. HolidayCheck Recommendation: '.$holidaycheck_score.'%</div>';


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
                
                echo '</div>
                <div class="request-details">
                  <ul>';
                  
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
                                        
                  echo '</ul>
                </div>';


               // accommodation 
               // flight 
            echo '</div>
          </div>
          <aside class="request-aside">
            <header class="request-aside-header"> 
            <img class="request-user-image" src="'.$imgURL.'" alt="user avatar"/>
              <div class="request-user-description">
                <p class="request-user-name">'.$user_login.'</p>
                <p class="request-timespan">'.time_elapsed_string(strtotime($post_modified)).'</p>
              </div>
            </header>
            <div class="request-aside-content">
              <p class="request-answers" data-track-c="trip finder" >
              <a href="'.site_url().'/look-at-deal/?post_id='.$post_id.'" target="_blank" data-track-click="view request answers" data-track-a="view request answers" data-track-l="1 Deal-Vorschlag">';
              // 1 Deal suggestion
              
    $commentQuerystr = "SELECT $wpdb->comments.* FROM $wpdb->comments WHERE $wpdb->comments.comment_post_ID = $post_id and $wpdb->comments.comment_approved=1";
    $pagepostsComment = $wpdb->get_results($commentQuerystr, OBJECT);
    if(count($pagepostsComment)>0)
    {
      echo count($pagepostsComment)." comments";
    }
              echo '</a></p>
              <p class="request-budget"><span class="">'.$request_budget.'<span class="currency_eur">&euro;</span></span></p>
              <p class="request-unit-type">'.$unit_type.'</p>
              <a href="'.site_url().'/look-at-deal/?post_id='.$post_id.'" target="_blank" data-track-click="view request button" data-track-l="location: request listing" class="request-button button button--lnk w--1">Anschauen</a> </div>
          </aside>
        </article>';
      }
      ?>

        
        
        
        
        
        <div class="pagi"> <a class="pagi-n" rel="next" href="#">Ältere Anfragen</a> </div>
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
<script src="<?php echo get_template_directory_uri(); ?>/js/base.js"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/js/front.js"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/js/browser_front.js"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap.min.js"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap-datepicker.js"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/js/date-picker.js?v=1.1"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.dropdown.js"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/js/select2.js?v=3.4.5"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/js/select2_locale_de.js"></script> 
<script src="<?php echo get_template_directory_uri(); ?>/js/listing-filters.js"></script>
			
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
