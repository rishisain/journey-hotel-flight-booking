<!doctype html>
<html class="no-js preload" lang="de-DE">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
<title>New Form</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--[if gt IE 8]><!-->
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/base_de.css">
<!--<![endif]-->
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/select2.css">


</head>
<body class="page">
<!-- <div ng-controller="MyCtrl">
  <select ng-options="size as size.name for size in sizes " ng-model="item" ng-change="update()"></select>
 {{item.code}} {{item.name}}
</div> 

<p>Name: <input type="text" ng-model="name"></p>
  qqq: <p ng-bind="name"></p>
-->
<div class="contentWrapper">
  <div class="contentBox" ng-app="travelRequest" id="ng-app">
    <div class="contentBox-main">
      <div class="contentBox-section">
        <div class="contentBox-subSection">
          <ul class="form-lst">
            <label for="travel_request_type" class="form-lb">I need</label>
            <div class="form-ct" ng-controller="RequestType">
              <select id="travelIitemId" class="input" ng-model="travelIitem" ng-change="changeRequestType()">
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
              <span class="itinerary-span-3 display-none">FLUG</span>
              </span> 
              </a>
              </li>
              <li class="contentBoxTabs-item dates-li"> 
              <a href="#">
              <i class="tabIcon tabIcon-dates"></i> 
              <span class="contentBoxTabs-item-label dates-span">Date</span> 
              </a>
              </li>
              <li class="contentBoxTabs-item accommodation-li"> 
              <a href="#">
              <i class="tabIcon tabIcon-accommodation"></i> 
              <span class="contentBoxTabs-item-label accommodation-span">Accommodation</span> 
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
                    <input class="geocomplete" id="departure" select2 value="" data-multiselect="1" placeholder="City or Airport" data-location-type="to" type="text" style="width:250px" />
                  </div>
                </li>
                <li class="form-row requires-request-1 requires-request-2 requires-request-3_1 display-none">
                  <label for="from" class="form-lb">Destination</label>
                  <div class="form-ct">
                    <input class="geocomplete" id="destination" select2 value="" data-multiselect="1" placeholder="City or Airport" data-location-type="to" type="text" style="width:250px" />
                  </div>
                </li>
                

                  <li class="form-row requires-request-1 requires-request-2 requires-request-3_2 display-none">
                  <label for="from" class="form-lb">Departure / arrival</label>
                  <div class="form-ct">
                    <input class="geocomplete" id="departure_arrival" select2 value="" data-multiselect="1" placeholder="City or Airport" data-location-type="to" type="text" style="width:250px" />
                  </div>
                </li>
                <li class="form-row requires-request-1 requires-request-2 requires-request-3_2 display-none">
                  <label for="from" class="form-lb">Destination / e</label>
                  <div class="form-ct">
                    <input class="geocomplete" id="destination_e" select2 value="" data-multiselect="1" placeholder="Ort oder Flughafen" data-location-type="to" type="text" style="width:250px" />
                  </div>
                </li>

                <li class="form-row requires-request-1 requires-request-2 requires-request-3_3 display-none">
                  <label for="from" class="form-lb">Destination / e or stops</label>
                  <div class="form-ct">
                    <input class="geocomplete" id="Destination_e_stops" select2 value="" data-multiselect="1" placeholder="City or Airport" data-location-type="to" type="text" style="width:250px" />
                  </div>
                </li>
                <li class="form-row requires-request-1 requires-request-2 requires-request-3_3 display-none">
                  <label for="from" class="form-lb">The ultimate goal / Return location</label>
                  <div class="form-ct">
                    <input class="geocomplete" id="ultimate_goal_return_location" select2 value="" data-multiselect="1" placeholder="City or Airport" data-location-type="to" type="text" style="width:250px" />
                  </div>
                </li>
                
                <li class="form-row requires-request-2 requires-request-3">
                  <label for="from" class="form-lb">Departure from</label>
                  <div class="form-ct">
                    <input class="geocomplete" id="number_of_departure" type="text" value="" placeholder="Ort oder Flughafen" style="width:250px" />
                  </div>
                </li>
                <li class="form-row requires-request-3">
                  <label for="from" class="form-lb">I want to go</label>
                  <div class="form-ct">
                    <input class="geocomplete" id="number_of_wantGo" select2 value="" data-multiselect="1" placeholder="Ort oder Flughafen" data-location-type="to" type="text" style="width:250px" />
                  </div>
                </li>
                <li class="form-row requires-request-3">
                  <label for="exclude" class="form-lb">Except (optional)</label>
                  <div class="form-ct">
                    <input class="geocomplete" id="number_of_except" select2 data-multiselect="1" value="" placeholder="Ort oder Flughafen" data-location-type="exclude" type="text" style="width:250px" />
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
                <li class="form-row" > <span class="form-lb"></span>
                  <div class="form-ct">
                    <select name="duration_type" class="input" ng-model="data.duration_type">
                      <option value="fix">The duration is set</option>
                      <option value="flex">The duration is flexible</option>
                    </select>
                  </div>
                </li>
                <li class="form-row">
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
              <li class="form-row">
                <label for="price_level" class="form-lb">Hotel price range</label>
                <div class="form-ct">
                  <select class="input" id="price_level" name="price_level" ng-model="data.price_level">
                    <option value="simple">simple</option>
                    <option value="normal">normal</option>
                    <option value="luxury">luxury</option>
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
              <li class="form-row">
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

        <!-- Overview SECTION START-->

      <div class="contentBox-section contentBox-overview-section display-none" ng-model="Overview" ng-controller="Overview">
          <div class="contentBoxHeading">
              <h1 class="contentBoxHeading-title">And so, your request will look like:</h1>
              <h2 class="contentBoxHeading-description">Please check your details, please complete and helpful information.</h2>
            </div>
          <form method="POST" id="overview-form" action="look-at-deal" ng-submit="overviewForm()" accept-charset="UTF-8">
            <input name="_token" type="hidden">
              <input name="section" type="hidden" value="overview">
              <ul class="form-lst">
                <li class="form-row">
                  <label for="request_title" class="form-lb">Title</label>
                  <div class="form-ct">
                    <input type="text" id="request_title" name="request_title" class="input"  placeholder="z.B. Familienurlaub in der Toskana für 2 Wochen" tabindex="1" ng-model="data.request_title" required="required" />
                    <span class="form-nfoI">0 / 130</span> </div>
                </li>
                <li class="form-row">
                  <label for="request_details" class="form-lb">Comments (optional)</label>
                  <div class="form-ct">
                    <textarea name="request_details" rows="6" class="input"  tabindex="2" ng-model="data.request_details"></textarea>
                    <span class="form-nfoI">0 / 600</span> </div>
                </li>
                <li class="form-row">
                  <label for="request_budget" class="form-lb">The budget is</label>
                  <div class="form-ct">
                    <input type="number" name="request_budget"  class="input" tabindex="3" ng-model="data.request_budget" required="required" />
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
                        <span class="request-people"></span><span class="request-people-alterKind"></span></div>
                    </header>
                    <div class="request-main-content"> 
                      <!-- travel package -->
                      <div class="request-package-duration">One week in</div>
                      <div class="request-location" id="requestLocation"></div>
                      <div class="request-package-from" id="requestFrom"></div>
                      <div class="request-package-from" id="requestExcept"></div>
                      <div class="request-package-type"></div>
                      <div class="request-details"></div>
                      <div class="request-description">{{data.request_details}}</div>
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

  </div>



        <div style="diplay: inline-block; float: right;" class="login-register-span">
        <?php
          if ( !is_user_logged_in() ) {
        echo '<span style="text-decoration: underline; cursor:pointer;" onclick="loginClick()">I must still register</span>
        <span style="text-decoration: underline; cursor:pointer;" class="display-none" onclick="registerClick()">I already have an account</span>';            
          }
        ?>
        </div>
        <div style="diplay: inline-block;">
        <div class="user-login"><?php echo do_shortcode( '[wppb-login]' ) ?></div>
        <div class="user-register display-none"><?php echo do_shortcode( '[wppb-register]' ) ?></div>
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
        </script>            <script id="modalConfirmTpl" type="text/html">
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

<script>
      $(function(){
        
        $(".geocomplete").geocomplete()
          .bind("geocode:result", function(event, result){
            $.log("Result: " + result.formatted_address);
          })
          .bind("geocode:error", function(event, status){
            $.log("ERROR: " + status);
          })
          .bind("geocode:multiple", function(event, results){
            $.log("Multiple: " + results.length + " results found");
          });    
                
      });
    </script>
 

</body>
</html>
