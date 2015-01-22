<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); ?>

<div id="main-content" class="main-content">

<?php
  if ( is_front_page() && twentyfourteen_has_featured_posts() ) {
    // Include the featured content template.
    get_template_part( 'featured-content' );
  }
?>

  <div id="primary" class="content-area">
    <div id="content" class="site-content" role="main">

      <div class="contentWrapper">
 <div class="contentBox">
    <div class="contentBox-main">
    <div ng-app="travelRequest" id="ng-app">
      <div class="contentBox-section">
        <div class="contentBox-subSection">
          <ul class="form-lst">
            <label for="travel_request_type" class="form-lb">I need</label>
            <div class="form-ct" ng-controller="RequestType">
              <select id="travel_item_id" class="input" ng-model="travel_item" ng-change="changeRequestType()">
                <option value="1">a journey</option>
                <option value="2">a hotel</option>
                <option value="3">a flight</option>
              </select>
            </div>
          </ul>
        </div>
      </div>
      <div class="contentBox-section contentBox-section--wide">
        <div class="contentBox-subSection">
          <nav class="contentBoxTabs" ng-controller="RequestTab">
            <ul class="contentBoxTabs-list">
              <li class="contentBoxTabs-item travellers-li"> 
              <a href="#">
              <i class="tabIcon tabIcon-travellers"></i> 
              <span class="contentBoxTabs-item-label travellers-span ">Travelers</span> 
              </a> 
              </li>
              <li class="contentBoxTabs-item itinerary-li"> 
              <a href="#">
              <i class="tabIcon tabIcon-itinerary"></i> 
              <span class="contentBoxTabs-item-label itinerary-span">
              <span class="itinerary-span-1 display-none">ROUTE</span>
              <span class="itinerary-span-2 display-none">PLACE</span>
              <span class="itinerary-span-3 display-none">FLIGHT</span>
              </span> 
              </a>
              </li>
              <li class="contentBoxTabs-item dates-li"> 
              <a href="#">
              <i class="tabIcon tabIcon-dates"></i> 
              <span class="contentBoxTabs-item-label dates-span">Date</span> 
              </a>
              </li>
              <li class="contentBoxTabs-item accommodation-li display-none"> 
              <a href="#">
              <i class="tabIcon tabIcon-accommodation"></i> 
              <span class="contentBoxTabs-item-label accommodation-span">Accommodation</span> 
              </a>
              </li>
              <li class="contentBoxTabs-item flight_details-li display-none"> 
              <a href="#"> 
              <i class="tabIcon tabIcon-flight_details"></i> 
              <span class="contentBoxTabs-item-label flight_details-span">Flight details</span> 
              </a> 
              </li>
              <li class="contentBoxTabs-item overview-li"> 
              <a href="#">
              <i class="tabIcon tabIcon-overview"></i> 
              <span class="contentBoxTabs-item-label overview-span">Overview</span> 
              </a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
      <!-- <div ng-cloak> -->
      <div class="contentBoxMain-section">
        <!-- TRAVELLERS SECTION START-->
        <div class="contentBox-section contentBox-travellers-section display-none">
          <div class="contentBoxHeading">
            <h1 class="contentBoxHeading-title">Here we go!</h1>
            <h2 class="contentBoxHeading-description">Enter the number of passengers</h2>
          </div>
          <div>
            <form method="POST" ng-submit="travellersForm()" accept-charset="UTF-8" ng-controller="Travellers">
              <input name="_token" type="hidden" value="">
              <input name="section" type="hidden" value="travellers">
              <ul class="form-lst">
                <li class="form-row">
                  <label for="number_of_adults" class="form-lb">Grown Ups</label>
                  <div class="form-ct">
                    <select name="number_of_adults" id="number_of_adults" class="input" ng-model="data.number_of_adults" ng-change="changeNumberOfAdults()">
                      <option value="1">1 adult</option>
                      <option value="2">2 adult</option>
                      <option value="3">3 adult</option>
                      <option value="4">4 adult</option>
                      <option value="5">5 adult</option>
                      <option value="6">6 adult</option>
                      <option value="7">7 adult</option>
                      <option value="8">8 adult</option>
                    </select>
                  </div>
                <li>
                <li class="form-row">
                  <label for="number_of_kids" class="form-lb">Childrens</label>
                  <div class="form-ct">
               <select name="number_of_kids" id="number_of_kids" class="input" ng-model="data.number_of_kids" ng-change="changeKidNumber()">
                      <option value="0">Without children</option>
                      <option value="1">1 Kind</option>
                      <option value="2">2 Kinder</option>
                      <option value="3">3 Kinder</option>
                      <option value="4">4 Kinder</option>
                    </select>
                  </div>
                </li>
                
                <li class="form-row" ng-repeat="(index,age) in data.kid_age">
                    <label class="form-lb" for="kid_age">{{ index + 1 | kid }}</label>
                    <div class="form-ct">
                        <select name="kid_age[]" id="kid_age_{{index+1}}" class="input" onchange="changeKidAge(this.id,this.value);">
                            <option ng-repeat="num in data.input_num" value="{{ num }}">{{ num }}</option>
                        </select>
                    </div>
                </li>
                </ul>                                             
              
              <ul class="form-lst" id="alter_kid"></ul>

              <div class="iGrid iGrid--r iGrid--m contentBoxFooterNav">
                <div class="w--1-6 iGrid-it contentBoxFooterNav-item"> </div>
                <div class="w--1-6 iGrid-it contentBoxFooterNav-item">
                  <button type="submit" class="button button--act button--n">Further</button>
                </div>
              </div>
            </form>
            <div class="clar"></div>
            <hr>
          </div>
        </div>
        <!-- TRAVELLERS SECTION END-->

        <!-- Itinerary SECTION START-->
          <div class="contentBox-section contentBox-itinerary-section display-none">
          <div class="contentBoxHeading">
            <h1 class="contentBoxHeading-title">Where to go's up?</h1>
            <h2 class="contentBoxHeading-description">You can specify multiple locations.</h2>
          </div>
          <div>
            <form method="POST" ng-submit="itineraryForm()" accept-charset="UTF-8" ng-controller="Itinerary">
              <input name="_token" type="hidden" value="">
              <input name="section" type="hidden" value="itinerary">
              <!-- <ul class="form-lst" ng-cloak> -->
              <ul class="form-lst">
                <li class="form-row requires-request-1 requires-request-2">
                <label for="travel_requires_type" class="form-lb">Requires</label>
                <div class="form-ct">
                  <select id="requiresIitemId" class="input" ng-model="requiresItem" ng-change="changeRequiresType()">
                    <option value="1">One Way</option>
                    <option value="2">Return</option>
                    <option value="3">Gabelflug</option>
                  </select>
                </div>
                </li>

                  <li class="form-row requires-request-1 requires-request-2 requires-request-3_1 requires-request-3_3 display-none">
                  <label for="from" class="form-lb">Departure</label>
                  <div class="form-ct">
                    <input id="departure_txt" select2 value="" placeholder="City or Airport" type="text" style="width:250px" />
                    <br><input id="departure" class="pre">
                  </div>
                </li>
                <li class="form-row requires-request-1 requires-request-2 requires-request-3_1 display-none">
                  <label for="from" class="form-lb">Destination</label>
                  <div class="form-ct">
                    <input id="destination_txt" select2 value="" data-multiselect="1" placeholder="City or Airport" data-location-type="to" type="text" style="width:250px" />
                    <br><input id="destination" class="pre">
                  </div>
                </li>
                

                  <li class="form-row requires-request-1 requires-request-2 requires-request-3_2 display-none">
                  <label for="from" class="form-lb">Departure / arrival</label>
                  <div class="form-ct">
                    <input id="departure_arrival_txt" select2 value="" data-multiselect="1" placeholder="City or Airport" data-location-type="to" type="text" style="width:250px" />
                    <br><input id="departure_arrival" class="pre">
                  </div>
                </li>
                <li class="form-row requires-request-1 requires-request-2 requires-request-3_2 display-none">
                  <label for="from" class="form-lb">Destination / e</label>
                  <div class="form-ct">
                    <input id="destination_e_txt" select2 value="" data-multiselect="1" placeholder="Ort oder Flughafen" data-location-type="to" type="text" style="width:250px" />
                    <br><input id="destination_e" class="pre">
                  </div>
                </li>

                <li class="form-row requires-request-1 requires-request-2 requires-request-3_3 display-none">
                  <label for="from" class="form-lb">Destination / e or stops</label>
                  <div class="form-ct">
                    <input id="destination_e_stops_txt" select2 value="" data-multiselect="1" placeholder="City or Airport" data-location-type="to" type="text" style="width:250px" />
                    <br><input id="destination_e_stops" class="pre">
                  </div>
                </li>
                <li class="form-row requires-request-1 requires-request-2 requires-request-3_3 display-none">
                  <label for="from" class="form-lb">The ultimate goal / Return location</label>
                  <div class="form-ct">
                    <input class="geocomplete" id="ultimate_goal_return_location_txt" select2 value="" data-multiselect="1" placeholder="City or Airport" data-location-type="to" type="text" style="width:250px" />
                    <br><input id="ultimate_goal_return_location" class="pre">
                  </div>
                </li>
                
                <li class="form-row requires-request-2 requires-request-3">
                  <label for="from" class="form-lb">Departure from</label>
                  <div class="form-ct">
                    <input class="geocomplete" id="number_of_departure_txt" type="text" value="" placeholder="Ort oder Flughafen" style="width:250px" />
                    <br><input id="number_of_departure" class="pre">
                  </div>
                </li>
                <li class="form-row requires-request-3">
                  <label for="from" class="form-lb">I want to go</label>
                  <div class="form-ct">
                    <input id="number_of_wantGo_txt" select2 value="" data-multiselect="1" placeholder="Ort oder Flughafen" data-location-type="to" type="text" style="width:250px" />
                    <br><input id="number_of_wantGo" class="pre">
                  </div>
                </li>
                <li class="form-row requires-request-3">
                  <label for="exclude" class="form-lb">Except (optional)</label>
                  <div class="form-ct">
                    <input id="number_of_except_txt" select2 data-multiselect="1" value="" placeholder="Ort oder Flughafen" data-location-type="exclude" type="text" style="width:250px" />
                    <br><input id="number_of_except" class="pre">
                  </div>
                </li>
              </ul>
              <input ng-repeat="loc in data.from" type="hidden" name="" value="" />
              <input ng-repeat="loc in data.to" type="hidden" name="" value="" />
              <input ng-repeat="loc in data.exclude" type="hidden" name="" value="" />
              <div class="iGrid iGrid--r iGrid--m contentBoxFooterNav">
                <div class="w--1-6 iGrid-it contentBoxFooterNav-item"> <a href="#" class="link">&lt; Back</a> </div>
                <div class="w--1-6 iGrid-it contentBoxFooterNav-item">
                  <button type="submit" class="button button--act button--n">Further</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <!-- Itinerary SECTION START-->
        <!-- DATE SECTION START-->

        <div class="contentBox-section contentBox-dates-section display-none">
          <div class="contentBoxHeading">
            <h1 class="contentBoxHeading-title">And when do you think?</h1>
            <h2 class="contentBoxHeading-description">Limit the time frame.</h2>
          </div>
          <div>
            <form method="POST" ng-submit="datesForm()" accept-charset="UTF-8" ng-controller="Dates">
              <input name="_token" type="hidden" value="">
              <input name="section" type="hidden" value="dates">
              <ul class="form-lst">
                <li class="form-row display-none"> <span class="form-lb"></span>
                  <div class="form-ct">
                    <select name="duration_type" class="input" ng-model="data.duration_type">
                      <option value="fix">The duration is set</option>
                      <option value="flex">The duration is flexible</option>
                    </select>
                  </div>
                </li>
                <li class="form-row display-none">
                  <label for="duration_from" class="form-lb">As long as I want to travel</label>
                  <div class="form-ct" ng-switch="data.duration_type">
                    <select name="duration_from" ng-model="data.duration_from">
                      <option ng-selected="num == data.duration_from" ng-repeat="num in data.input_num" value="{{ num }}">{{ num }}</option>
                    </select>
                    <span ng-switch-when="flex">to</span>
                    <select name="duration_to" ng-switch-when="flex" ng-model="data.duration_to">
                      <option ng-selected="num == data.duration_to" ng-repeat="num in data.input_num" value="{{ num }}">{{ num }}</option>
                    </select>
                    <select name="duration_unit" ng-model="data.duration_unit">
                      <option value="weeks">Week / s</option>
                      <option value="days">Day / s</option>
                      <option value="months">Month / s</option>
                    </select>
                  </div>
                </li>
                <li class="form-row">
                  <label for="earliest_at" class="form-lb">Earliest check-out date</label>
                  <div class="form-ct">
                    <input type="text" id="earliest_at" data-start-date name="earliest_at" class="input" data-date="{{ data.earliest_at }}" data-date-format="dd-mm-yyyy" value="{{ data.earliest_at }}" ng-model="data.earliest_at"/>
                  </div>
                </li>
                <li class="form-row">
                  <label for="latest_at" class="form-lb">Latest return</label>
                  <div class="form-ct">
                    <input type="text" id="latest_at" data-end-date name="latest_at" class="input" data-date="{{ data.latest_at }}" data-date-format="dd-mm-yyyy" value="{{ data.latest_at }}" ng-model="data.latest_at"/>
                  </div>
                </li>
              </ul>
              <div class="iGrid iGrid--r iGrid--m contentBoxFooterNav">
                <div class="w--1-6 iGrid-it contentBoxFooterNav-item"> <a href="#" class="link">&lt; Back</a> </div>
                <div class="w--1-6 iGrid-it contentBoxFooterNav-item">
                  <button type="submit" class="button button--act button--n">Further</button>
                </div>
              </div>
            </form>
          </div>
        </div>

        <!-- DATE SECTION END-->

        <!-- Accommodation SECTION START-->

        <div class="contentBox-section contentBox-accommodation-section display-none">
          <div class="contentBoxHeading">
            <h1 class="contentBoxHeading-title">How would you like to live during the trip?</h1>
            <h2 class="contentBoxHeading-description">Tell us more about your claims to the property.</h2>
          </div>
          <form method="POST" ng-submit="accommodationForm()" accept-charset="UTF-8" ng-controller="Accommodation">
            <input name="_token" type="hidden" value="">
            <input name="section" type="hidden" value="accommodation">
            <ul class="form-lst">
              <li class="form-row display-none">
                <label for="price_level" class="form-lb">Hotel price range</label>
                <div class="form-ct">
                  <select class="input" id="price_level" name="price_level" ng-model="data.price_level">
                    <option value="simple">simple</option>
                    <option value="normal">normal</option>
                    <option value="luxury">luxury</option>
                  </select>
                </div>
              </li>
              
              <li class="form-row display-none">
              <label for="accommodation_type" class="form-lb">Qualify</label>
              <div class="form-ct">
              <select class="input" id="accommodation_type" name="accommodation_type" ng-model="data.accommodation_type">
              <option value="Hotels and Apartments">Hotels and Apartments</option>
              <option value="Only hotels">Only hotels</option>
              </select>
              </div>
              </li>

              <li class="form-row display-none">
              <label for="minimum_category" class="form-lb">Minimum Number of stars</label>
              <div class="form-ct">
              <select class="input" id="minimum_category" name="minimum_category" ng-model="data.minimum_category">
              <option value="0">I do not care</option>
              <option value="3">3 stars</option>
              <option value="4">4 stars</option>
              <option value="5">5 Stars</option>
              </select>
              </div>
              </li>
              
              <li class="form-row">
                <label for="board" class="form-lb">Catering</label>
                <div class="form-ct">
                  <select class="input" id="board" name="board" ng-model="data.board">
                    <option value="Give a damn">Give a damn</option>
                    <option value="Without food">Without food</option>
                    <option value="Breakfast only">Breakfast only</option>
                    <option value="Half board">Half board</option>
                    <option value="Full board">Full board</option>
                    <option value="All inclusive">All inclusive</option>
                  </select>
                </div>
              </li>

              <li class="form-row display-none">
              <label for="tripadvisor_score" class="form-lb">TripAdvisor Mindestbewertung</label>
              <div class="form-ct">
              <select class="input" id="tripadvisor_score" name="tripadvisor_score" ng-model="data.tripadvisor_score">
              <option value="30">3 points</option>
              <option value="35">3.5 points</option>
              <option value="40">4 points</option>
              <option value="45">4.5 points</option>
              </select>
              </div>
              </li>

              <li class="form-row display-none">
              <span class="form-lb"></span>
              <div class="form-ct">
              <input name="wlan" id="wlan" type="checkbox" ng-model="data.wlan">    
              <label for="wlan" class="goog-text-highlight">With Wi-Fi</label>
              </div>
              </li>

              <li class="form-row display-none">
                <label for="holidaycheck_score" class="form-lb">Minute Holiday Recommendation</label>
                <div class="form-ct">
                  <select class="input" id="holidaycheck_score" name="holidaycheck_score" ng-model="data.holidaycheck_score">
                    <option value="50">50%</option>
                    <option value="60">60%</option>
                    <option value="70">70%</option>
                    <option value="80">80%</option>
                    <option value="85">85%</option>
                    <option value="90">90%</option>
                    <option value="95">95%</option>
                  </select>
                </div>
              </li>
              <li class="form-row">
                <label for="notes" class="form-lb">Near ... (optional)</label>
                <div class="form-ct">
                  <textarea placeholder="z.B. Flughafen, Stadtmitte, Strand …" class="input" name="notes" cols="50" rows="10" id="notes" ng-model="data.notes"></textarea>
                </div>
              </li>
            </ul>
            <div class="iGrid iGrid--r iGrid--m contentBoxFooterNav">
              <div class="w--1-6 iGrid-it contentBoxFooterNav-item"> 
              <a href="#" class="link">&lt; Back</a> </div>
              <div class="w--1-6 iGrid-it contentBoxFooterNav-item">
                <button type="submit" class="button button--act button--n">Further</button>
              </div>
            </div>
          </form>
        </div>

        <!-- Accommodation SECTION END-->

        <!-- Flight Details SECTION START-->
<!-- <form method="POST" ng-submit="flightDetailsForm()" accept-charset="UTF-8" ng-controller="FlightDetails"> -->
        <div class="contentBox-section contentBox-flight_details-section display-none">
          <div class="contentBoxHeading">
            <h1 class="contentBoxHeading-title">How would you like to fly?</h1>
            <h2 class="contentBoxHeading-description">It's up to you: billg or travel in comfort, or rather a mix?</h2>
          </div>
  <form method="POST" ng-submit="flightDetailsForm()" accept-charset="UTF-8" ng-controller="FlightDetails">
  <input name="section" type="hidden" value="flight_details">
  <ul class="form-lst">
    <li class="form-row">
      <label for="class" class="form-lb">I prefer</label>
      <div class="form-ct">
        <select class="input" id="clas" name="clas" ng-model="data.clas">
          <option value="Economy class">Economy class</option>
          <option value="Business class">Business class</option>
          <option value="First Class">First Class</option>
        </select>
      </div>
    </li>
    <li class="form-row">
      <label for="airline_type" class="form-lb">Airline Options</label>
      <div class="form-ct">
        <select class="input" id="airline_type" name="airline_type" ng-model="data.airline_type">
          <option value="I am all right.">I am all right</option>
          <option value="No budget airlines!">No budget airlines!</option>
          <option value="premium_airlines.">Premium Airlines!</option>
        </select>
      </div>
    </li>
    <li class="form-row"> <span class="form-lb"></span>
      <div class="form-ct">
        <input id="railfly" name="railfly" ng-model="data.railfly" type="checkbox">
        <label for="railfly">I want to use Rail &amp; Fly</label>
      </div>
    </li>
    <li class="form-row"> <span class="form-lb"></span>
      <div class="form-ct">
        <input id="nearby_airports" name="nearby_airports" ng-model="data.nearby_airports" type="checkbox">
        <label for="nearby_airports">Area Airports are ok</label>
      </div>
    </li>
    <li class="form-row"> <span class="form-lb"></span>
      <div class="form-ct">
        <input id="multistops" name="multistops" ng-model="data.multistops" type="checkbox">
        <label for="multistops">Stopovers are ok, if it saves money</label>
      </div>
    </li>
    <li class="form-row"> <span class="form-lb"></span>
      <div class="form-ct">
        <input id="collect_miles" name="collect_miles" ng-model="data.collect_miles" type="checkbox">
        <label for="collect_miles">I collect miles</label>
      </div>
    </li>
    <li class="form-row">
      <label for="collect_with" class="form-lb">For air miles I use</label>
      <div class="form-ct">
        <input class="input" placeholder="Vielfliegerprogramm eingeben" disabled="disabled" name="collect_with" type="text" id="collect_with">
      </div>
    </li>
  </ul>
  <div class="iGrid iGrid--r iGrid--m contentBoxFooterNav">
    <div class="w--1-6 iGrid-it contentBoxFooterNav-item"> <a href="#" class="link">&lt;Back</a> </div>
    <div class="w--1-6 iGrid-it contentBoxFooterNav-item">
      <button type="submit" class="button button--act button--n">Further</button>
    </div>
  </div>
</form>
        </div>

        <!-- Flight Details SECTION END-->


        <!-- Overview SECTION START-->

      <div class="contentBox-section contentBox-overview-section display-none" ng-model="Overview" ng-controller="Overview">
          <div class="contentBoxHeading">
              <h1 class="contentBoxHeading-title">And so, your request will look like:</h1>
              <h2 class="contentBoxHeading-description">Please check your details, please complete and helpful information.</h2>
            </div>
          <form method="POST" ng-submit="overviewForm()" action="look-at-deal" accept-charset="UTF-8">
            <input name="_token" type="hidden">
              <input name="section" type="hidden" value="overview">
              <ul class="form-lst">
                <li class="form-row">
                  <label for="request_title" class="form-lb">Title</label>
                  <div class="form-ct">
                    <input type="text" id="request_title" ng-keyup="countChar('request_title',130)" name="request_title" class="input"  placeholder="z.B. Familienurlaub in der Toskana für 2 Wochen" tabindex="1" ng-model="data.request_title" required />
                    <span class="form-nfoI"><span>0</span> / 130</span> </div>
                </li>
                <li class="form-row">
                  <label for="request_description" class="form-lb">Comments (optional)</label>
                  <div class="form-ct">
                    <textarea name="request_description" id="request_description" ng-keyup="countChar('request_description',600)" rows="6" class="input"  tabindex="2" ng-model="data.request_description"></textarea>
                    <span class="form-nfoI">0 / 600</span> </div>
                </li>
                <li class="form-row">
                  <label for="request_budget" class="form-lb">The budget is</label>
                  <div class="form-ct">
                    <input type="number" name="request_budget" min="1"  class="input" tabindex="3" ng-model="data.request_budget" required />
                  </div>
                </li>
                <li class="form-row"> <span class="form-lb"></span>
                  <div class="form-ct">
                    <select name="currency" ng-model="data.currency" class="w--1-4" tabindex="4">
                      <option value="currency_eur">&euro;</option>
                    </select>
                    <select name="unit_type" ng-model="data.unit_type" class="w--1-4" tabindex="5">
                      <option value="per person">per person</option>
                      <option value="total">all in all</option>
                      <option value="per night">per night</option>
                    </select>
                  </div>
                </li>
              </ul>
              <div id="preview">
                <article class="request w--1 request--tr">
                  <div class="request-main w--3-4">
                    <header class="request-main-header"> <span class="request-cat" href="">category name</span> <a href="">
                      <h2 class="request-headline">{{data.request_title}}</h2>
                      </a>
                      <div class="request-meta">
                        <time class="request-date-range"></time>
                        <span class="request-people"></span><span class="request_people_alterKind"></span></div>
                    </header>
                    <div class="request-main-content"> 
                      <!-- travel package -->
                      <div class="request-package-duration">One week in</div>
                      <div class="request-location" id="requestLocation"></div>
                      <div class="request-package-from" id="requestFrom"></div>
                      <div class="request-package-from" id="requestExcept"></div>
                      <div class="request-package-type"></div>
                      <div class="request-details"></div>
                      <div class="request-description">{{data.request_description}}</div>
                    </div>
                  </div>
                  <aside class="request-aside w--1-4">
                    <div class="request-aside-content">
                      <p class="request-answers"></p>
                      <p class="request-budget">{{data.request_budget}}&euro;</p>
                      <p class="request-unit-type"> {{data.unit_type}} </p>
                    </div>
                  </aside>
                </article>
              </div>
              <div class="contentBox-subSection">
                <div class="iGrid iGrid--r iGrid--m contentBox-updateConfirmation">
                  <input type="checkbox" name="confirm_updates" id="confirm_updates" ng-model="data.confirm_updates"/>
                  <label for="confirm_updates">Notify me of replies to my question</label>
                </div>
                <div class="iGrid iGrid--r iGrid--m contentBoxFooterNav">
                  <div class="w--1-6 iGrid-it contentBoxFooterNav-item"> <a href="http://www.urlaubspiraten.de/reisefinder/submission?section=accommodation" class="link">&lt; Back</a> </div>
                  <div class="w--1-4 iGrid-it contentBoxFooterNav-item">
                  <input type="hidden" name="request_people_alterKind_hid" ng-model="data.request_people_alterKind_hid">
                  <input type="hidden" ng-model="data.travel_item_hid" name="travel_item_hid" id="travel_item_hid">
                  <input type="hidden" ng-model="data.number_of_adults_hid" name="number_of_adults_hid" id="number_of_adults_hid">
                  <input type="hidden" ng-model="data.number_of_kids_hid" name="number_of_kids_hid" id="number_of_kids_hid">
                  <input type="hidden" ng-model="data.departure_hid" name="departure_hid" id="departure_hid">
                  <input type="hidden" ng-model="data.destination_hid" name="destination_hid" id="destination_hid">
                  <input type="hidden" ng-model="data.departure_arrival_hid" name="departure_arrival_hid" id="departure_arrival_hid">
                  <input type="hidden" ng-model="data.destination_e_hid" name="destination_e_hid" id="destination_e_hid">
                  <input type="hidden" ng-model="data.destination_e_stops_hid" name="destination_e_stops_hid" id="destination_e_stops_hid">
                  <input type="hidden" ng-model="data.ultimate_goal_return_location_hid" name="ultimate_goal_return_location_hid" id="ultimate_goal_return_location_hid">
                  <input type="hidden" ng-model="data.number_of_departure_hid" name="number_of_departure_hid" id="number_of_departure_hid">
                  <input type="hidden" ng-model="data.number_of_wantGo_hid" name="number_of_wantGo_hid" id="number_of_wantGo_hid">
                  <input type="hidden" ng-model="data.number_of_except_hid" name="number_of_except_hid" id="number_of_except_hid">
                  <input type="hidden" ng-model="data.requiresItem_hid" name="requiresItem_hid" id="requiresItem_hid">
                  <input type="hidden" ng-model="data.duration_type_hid" name="duration_type_hid" id="duration_type_hid">
                  <input type="hidden" ng-model="data.duration_from_hid" name="duration_from_hid" id="duration_from_hid">
                  <input type="hidden" ng-model="data.duration_to_hid" name="duration_to_hid" id="duration_to_hid">
                  <input type="hidden" ng-model="data.duration_unit_hid" name="duration_unit_hid" id="duration_unit_hid">
                  <input type="hidden" ng-model="data.earliest_at_hid" name="earliest_at_hid" id="earliest_at_hid">
                  <input type="hidden" ng-model="data.latest_at_hid" name="latest_at_hid" id="latest_at_hid">
                  
                  <input type="hidden" ng-model="data.clas_hid" name="clas_hid" id="clas_hid">
                  <input type="hidden" ng-model="data.airline_type_hid" name="airline_type_hid" id="airline_type_hid">
                  <input type="hidden" ng-model="data.railfly_hid" name="railfly_hid" id="railfly_hid">
                  <input type="hidden" ng-model="data.nearby_airports_hid" name="nearby_airports_hid" id="nearby_airports_hid">
                  <input type="hidden" ng-model="data.multistops_hid" name="multistops_hid" id="multistops_hid">
                  <input type="hidden" ng-model="data.collect_miles_hid" name="collect_miles_hid" id="collect_miles_hid">

                  <input type="hidden" ng-model="data.price_level_hid" name="price_level_hid" id="price_level_hid">
                  
                  <input type="hidden" ng-model="data.accommodation_type_hid" name="accommodation_type_hid" id="accommodation_type_hid">
                  <input type="hidden" ng-model="data.minimum_category_hid" name="minimum_category_hid" id="minimum_category_hid">
                  
                  <input type="hidden" ng-model="data.board_hid" name="board_hid" id="board_hid">
                  
                  <input type="hidden" ng-model="data.tripadvisor_score_hid" name="tripadvisor_score_hid" id="tripadvisor_score_hid">
                  <input type="hidden" ng-model="data.wlan_hid" name="wlan_hid" id="wlan_hid">
                  
                  <input type="hidden" ng-model="data.holidaycheck_score_hid" name="holidaycheck_score_hid" id="holidaycheck_score_hid">
                  <input type="hidden" ng-model="data.notes_hid" name="notes_hid" id="notes_hid">

          <?php
          if ( is_user_logged_in() ) {
            echo '<input class="button button--pAct button--n" value="Publish request" data-value="Publish request" type="submit">';
          } else {
            echo '<input disabled="disabled" class="button button--pAct button--n" value="Publish request" data-value="Publish request" type="submit">';
          }
          ?>
                    
                  </div>
                </div>
              </div>
          </form>

          <div class="contentBox-subSection">
        <div class="contentBoxHeading">
            <h1 class="contentBoxHeading-title"><font><font>Please log in</font></font></h1>
            <h2 class="contentBoxHeading-description"><font><font>We would like to inform you of replies</font></font></h2>
        </div>
             
       



        </div>

        </div>
        
        <!-- Overview SECTION END-->

      </div>
      

    </div>
  
    <div class="clr"></div>
   
      <?php
      if($_GET['section']=='overview')
      {
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
      }     
     ?>




     </div>
 <div class="clr"></div>
  </div>

  






        

</div>


<p class="copyright">©2014 Urlaubspiraten</p>
            <script type="text/javascript">
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-22858434-1', 'urlaubspiraten.de');
    ga('require', 'displayfeatures');
    ga('send', 'pageview');
    ga('set', 'anonymizeIp', true);
    ga('set', 'dimension1', 'no');
        </script>        
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
    
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery-1.11.0.min.js"></script>
<script src="http://maps.googleapis.com/maps/api/js?libraries=places&sensor=false&language=nl"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.geocomplete.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap-datepicker.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/angular.1.2.0.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/cookies.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/underscore-min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/moment.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/angular-underscore.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/select2.js?v=3.4.5"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/select2_locale_de.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/submission.js?v=1.3"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/date-picker.js?v=1.2"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/logger.js"></script> 

<script>
      $(function(){
        
        $("#departure_txt").geocomplete()
          .bind("geocode:result", function(event, result){
            $.log(result.formatted_address,'departure');
          });
          $("#destination_txt").geocomplete()
          .bind("geocode:result", function(event, result){
            $.log(result.formatted_address,'destination');
          });
          $("#departure_arrival_txt").geocomplete()
          .bind("geocode:result", function(event, result){
            $.log(result.formatted_address,'departure_arrival');
          });
          $("#destination_e_txt").geocomplete()
          .bind("geocode:result", function(event, result){
            $.log(result.formatted_address,'destination_e');
          });
          $("#destination_e_stops_txt").geocomplete()
          .bind("geocode:result", function(event, result){
            $.log(result.formatted_address,'destination_e_stops');
          });
          $("#ultimate_goal_return_location_txt").geocomplete()
          .bind("geocode:result", function(event, result){
            $.log(result.formatted_address,'ultimate_goal_return_location');
          });
          $("#number_of_departure_txt").geocomplete()
          .bind("geocode:result", function(event, result){
            $.log(result.formatted_address,'number_of_departure');
          });
          $("#number_of_wantGo_txt").geocomplete()
          .bind("geocode:result", function(event, result){
            $.log(result.formatted_address,'number_of_wantGo');
          });
          $("#number_of_except_txt").geocomplete()
          .bind("geocode:result", function(event, result){
            $.log(result.formatted_address,'number_of_except');
          });        
                
      });
    </script>

    </div><!-- #content -->
  </div><!-- #primary -->
  <?php get_sidebar( 'content' ); ?>
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer();