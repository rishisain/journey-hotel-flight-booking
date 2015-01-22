
/*(function ($){
    // flight details page
    if($('#collect_miles').is(':checked'))
    {
        $('#collect_with').removeAttr('disabled');
    }

    if($('#collect_miles').on('click', function(){
        if($(this).is(':checked')){
            $('#collect_with').removeAttr('disabled');
        } else {
            $('#collect_with').attr('disabled', 'disabled');
        }
    }));

    // prevent submit on enter
    $(window).keydown(function(event){
        var code = event.keyCode || event.which;
        if(code == 13 && event.target.id == 'request_title') {
            event.preventDefault();

            var next_idx = parseInt($(':focus').attr('tabindex'), 10) + 1;
            var $next_input = $('form [tabindex=' + next_idx + ']');
            if($next_input.length)
                $next_input.focus();
            else
                $('form [tabindex]:first').focus();

            return false;
        }
    });

}(window.jQuery));

var travelRequest = angular.module('travelRequest', ['angular-underscore']);


travelRequest.filter('lang', function() {
    return function(input) {
        var lang = {
            per_person: 'pro Person',
            total: 'alles in allem',
            per_night: 'pro Nacht'
        };

        return lang[input];
    };
});

travelRequest.filter('kid', function() {
    return function(input) {
        return 'Alter ' + input + '. Kind';
    };
});

travelRequest.factory('Location', ['$http', function($http){
    return {
        search: function (q) {
            return $http.get('/reisefinder/location?name=' + q);
        }
    }
}]);

travelRequest.factory('User', ['$http', function($http){
    return {
        get: function () {
            return $http.get('/reisefinder/user');
        }
    }
}]);

travelRequest.factory('SavedData', ['$http', function($http){
    return {
        get: function (section) {
            var url = '/reisefinder/request-data';

            if(section)
            {
                url = '/reisefinder/request-data?section=' + section;
            }

            return $http.get(url);
        }
    }
}]);

travelRequest.controller('Travellers', ['$scope', 'SavedData', function ($scope, SavedData) {

        $scope.data = {
            number_of_adults: 1,
            number_of_kids: 0,
            kid_age: []
        };

        SavedData.get('travellers').success(function(response){
            $scope.data.request_type = response.content.request_type;

            if(response.content.data){
                $scope.data = response.content.data;
            }
        });

        $scope.changeKidNumber = function()
        {
            $scope.data.kid_age = [];
            for(var i = 0; i < $scope.data.number_of_kids; i++)
            {
                $scope.data.kid_age[i] = i;
            }
        }

    }])
    .controller('Itinerary', ['$scope', 'SavedData', function($scope, SavedData){

        $scope.data = {
            request_type: 1,
            to: [],
            from: [],
            exclude: []
        };

        $scope.locations = [];

        // load server data, transform and put it in scope
        SavedData.get('itinerary').success(function(response){

            var data = response.content.data;
            $scope.data.request_type = response.content.request_type;

            if(data){
                angular.forEach(data.destination, function(value, key){
                    this.push({id: key, label: value});
                }, $scope.data.to);

                angular.forEach(data.origin, function(value, key){
                    this.push({id: key, label: value});
                }, $scope.data.from);

                angular.forEach(data.exclude, function(value, key){
                    this.push({id: key, label: value});
                }, $scope.data.exclude);
            }

            if($scope.data.request_type == 2)
            {
                $scope.data.from = [];
            }

        });

        $scope.update = function (locations, locationType) {
            $scope.data[locationType] = [];

            angular.forEach(locations, function(value){
                this.push({
                    id: value,
                    label: $scope.locations[value].location_name
                });
            }, $scope.data[locationType]);

            $scope.$apply();
        };

        $scope.removeLocation = function (type, index) {
            $scope.data[type].splice(index, 1);
        };

        $scope.valid = function()
        {
            if($scope.data.to && $scope.data.from)
            {
                return true;
            }

            return false;
        }

    }])
    .controller('Flight', ['$scope', 'SavedData', function ($scope, SavedData) {

        $scope.data = {
            route_type: 'route_type_circle_trip',
            stops: [],
            origin: null,
            destination: null
        };

        $scope.locations = [];

        SavedData.get('flight').success(function(response){

            var data = response.content.data;
            $scope.data.request_type = response.content.request_type;

            if(data){
                $scope.data.route_type = data.route_type;

                angular.forEach(data.stops, function(value, key){
                    this.push({id: key, label: value});
                }, $scope.data.stops);

                $.each(data.origin, function(key, value){
                    $scope.data.origin = {id: key, label: value};
                });

                $.each(data.destination, function(key, value){
                    $scope.data.destination = {id: key, label: value};
                });
            }
        });

        $scope.valid = function()
        {
            if($scope.data.route_type === 'route_type_custom')
            {
                if($scope.data.origin && $scope.data.destination)
                {
                    return true;
                }
            }
            else
            {
                if($scope.data.origin && $scope.data.destination && $scope.data.stops)
                {
                    return true;
                }
            }

            return false;
        };

        $scope.update = function (location, locationType) {

            if (locationType === 'origin') {
                var origin = {
                    id: location,
                    label: $scope.locations[location].location_name
                };
                $scope.data.origin = origin;

                if ($scope.data.route_type == 'route_type_circle_trip') {
                    $scope.data.destination = origin;
                }
            }
            else if (locationType === 'destination') {
                var destination = {
                    id: location,
                    label: $scope.locations[location].location_name
                };
                $scope.data.destination = destination;

                if ($scope.data.route_type == 'route_type_circle_trip') {
                    $scope.data.origin = destination;
                }
            }
            else if (locationType === 'stops') {
                $scope.data[locationType] = [];

                angular.forEach(location, function(value){
                    this.push({
                        id: value,
                        label: $scope.locations[value].location_name
                    });
                }, $scope.data[locationType]);
            }
            $scope.$apply();
        };

        $scope.refresh = function () {

            if ($scope.data.route_type === 'route_type_circle_trip') {
                if($scope.data.origin){
                    $scope.data.destination = $scope.data.origin;
                } else {
                    $scope.data.destination = null;
                }
            }

            if ($scope.data.route_type === 'route_type_custom' || $scope.data.route_type === 'route_type_origin_open_jaw') {
                if($scope.data.origin && $scope.data.destination)
                {
                    if($scope.data.origin.geo_id === $scope.data.destination.geo_id)
                    {
                        $scope.data.destination = null;
                    }
                }
                $scope.data.stops = [];
            }
        };

        $scope.removeOriginLocation = function () {
            if ($scope.data.route_type == 'route_type_circle_trip') {
                $scope.data.destination = null;
            }
            $scope.data.origin = null;
        };

        $scope.removeDestinationLocation = function () {
            if ($scope.data.route_type == 'route_type_circle_trip') {
                $scope.data.origin = null;
            }
            $scope.data.destination = null;
        };

        $scope.removeStopLocation = function(index) {
            $scope.data.stops.splice(index, 1);
        }

    }])
    .controller('Dates', ['$scope', 'SavedData', function ($scope, SavedData) {

        $scope.data = {
            duration_type: 'fix',
            duration_from: null,
            duration_to: null,
            earliest_at: moment().format('DD-MM-YYYY'),
            latest_at: moment().add('days', 7).format('DD-MM-YYYY')
        };

        $scope.flight = {
            route_type: null
        };

        SavedData.get('dates').success(function(response){

            $scope.data.request_type = response.content.request_type;

            if(response.content.data){
                $scope.data = response.content.data;
            }
        });

        SavedData.get('flight').success(function(response){
            if(response.content.data){
                $scope.flight = response.content.data;
            }
        });

    }])
    .controller('Overview', ['$scope', '$http', 'SavedData', 'User', function ($scope, $http, SavedData, User) {

        $scope.data = {
            request_title: null,
            request_details: null,
            request_budget: 0,
            currency: 'currency_eur',
            unit_type: 'per_person'
        };

        $scope.lang = {};

        $scope.auth = {
            show_login_form: false,
            show_register_form: true,
            user_logged_in: false
        };

        $scope.user = null;

        $scope.error = {
            messages: []
        };

        $scope.valid = function(){
            if($scope.data.request_title)
            {
                return true;
            }
            return false;
        };

        $scope.data.previous_section_url = null;

        SavedData.get().success(function(response){
            if(response.content.data){
                $scope.saved_data = response.content.data.sections;
            }

            $scope.data.request_type = response.content.request_type;

            // check if this is accommodation type and see if there is 'unit_type'
            // if no, set default which is different from other types
            if($scope.data.request_type == 2 &&  $scope.data.unit_type != 'per_night')
            {
                $scope.data.unit_type = 'per_night';
            }

            $scope.data.previous_section_url = response.content.previous_section_url;

            $scope.lang = response.content.lang;

        });

        User.get().success(function(response)
        {
            if(response.user) {
                $scope.auth.user_logged_in = true;
                $scope.user = response.user;
            }
        });

        // auth methods
        $scope.toggleForms = function(){
            $scope.auth.show_login_form = !$scope.auth.show_login_form;
            $scope.auth.show_register_form = !$scope.auth.show_register_form;
        };

        $scope.login = function(){

            $scope.error.messages = [];

            var postData = {
                identity: this.login.identity,
                password: this.login.password
            };

            $http.post('/user/ajax-login', postData).success(function(response){
                if(response.status === 'OK')
                {
                    $scope.auth.user_logged_in = true;
                    $scope.user = response.user;
                }
                else if(response.status === 'ERROR')
                {
                    if(typeof response.message === 'string'){
                        $scope.error.messages.push(response.message)
                    } else {
                        $scope.error.messages = response.message;
                    }
                }
            });
        };

        $scope.register = function() {

            $scope.error.message = null;

            var postData = {
                email: this.register.email,
                username: this.register.username,
                tos: this.register.tos
            };

            $http.post('/user/force-signup', postData).success(function(response) {
                if(response.status === 'OK')
                {
                    $scope.auth.user_logged_in = true;
                }
                else if(response.status === 'ERROR')
                {
                    if(typeof response.message === 'string'){
                        $scope.error.messages.push(response.message)
                    } else {
                        $scope.error.messages = response.message;
                    }
                }
            });
        };

    }])
    .controller('RequestType', ['$scope', '$window', function ($scope, $window) {
        $scope.changeRequestType = function() {
            $window.location.href = '/reisefinder/submission?section=travellers&type=' + $scope.request.type;
        }

    }])
    .directive('finish', function(){
        return {
            restrict: 'E',
            replace: true,
            template: '<input>',
            link: function(scope, element)
            {
                element.attr('type', 'submit');
                element.attr('value', element.data('value'));
                element.attr('class', 'button button--pAct button--n');
                scope.$watch('auth.user_logged_in', function(newValue){
                    if(newValue)
                    {
                        element.removeAttr('disabled');
                    }
                    else
                    {
                        element.attr('disabled', 'disabled');
                    }
                });
            }
        }
    })
    .directive('money', function () {
        return {
            restrict: 'A',
            link: function (scope, element, attrs) {
                element.autoNumeric('init', {aSep: '.', aDec: ','});
                scope.$watch('data.request_budget', function (newValue) {
                    scope.request_budget = element.autoNumeric('get');
                    scope.$apply()
                });
            }
        }
    })
    .directive('select2', function() {
        return {
            restrict: 'A',
            link: function (scope, element, attrs) {
                element.select2({
                    id: function(item) {
                        return item.geo_id;
                    },
                    multiple: (element.data('multiselect') == 1)? true : false,
                    minimumInputLength: 3,
                    ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
                        url: "/reisefinder/location",
                        dataType: 'json',
                        data: function (term, page) {
                            return {
                                name: term // search term
                            };
                        },
                        results: function (data, page) { // parse the results into the format expected by Select2.
                            // since we are using custom formatting functions we do not need to alter remote JSON data
                            return {results: data};
                        }
                    },
                    formatSelection: function(item) {
                        return item.location_name;
                    },
                    formatResult: function(item) {
                        var location = item.location_name

                        if(item.state)
                        {
                            location += ', ' + item.state;
                        }

                        if(item.country)
                        {
                            location += ', ' + item.country;
                        }

                        return location;
                    },
                    escapeMarkup: function (m) {
                        return m;
                    },
                    initSelection: function(element, callback) {
                        var data = [];
                        var vals = [];

                        $(element.val().split(",")).each(function() {
                                var item = this.split(':');

                            if (element.data('multiselect') == 1) {

                                data.push({
                                    geo_id: item[0],
                                    location_name: item[1]
                                });
                            }
                            else
                            {
                                data = {
                                    geo_id: item[0],
                                    location_name: item[1]
                                };
                            }
                                vals.push(item[0]);

                                scope.locations[item[0]] = {
                                    geo_id: item[0],
                                    location_name: item[1]
                                };
                        });

                        element.val(vals);

                        callback(data);
                    }
                }).change(function(e){
                        if(e.added){
                            scope.locations[e.added.geo_id] = e.added;
                            scope.$apply();
                        }

                        scope.update(e.val, element.data('locationType'));
                    });
            }
        }
    });

*/

/*
var myApp = angular.module('travelRequest',[]);

//myApp.directive('myDirective', function() {});
//myApp.factory('myService', function() {});

function MyCtrl($scope) {
  $scope.sizes = [ {code: 1, name: 'n1'}, {code: 2, name: 'n2'}];
  $scope.update = function() {
    console.log($scope.item.code, $scope.item.name)
  };
}

function RequestType($scope) {
    alert(4444);
  $scope.changeRequestType = function() {
            alert(77);
            $window.location.href = '/reisefinder/submission?section=travellers&type=' + $scope.request.type;
  };
}
*/
var travel_item;
var numberOfAdults;
var rangeDetector = function(total)
{
    var optionTag='';
    for (var i=0; i<total; i++)
    {
        optionTag+='<option ng-repeat="num in data.input_num" value="'+i+'" class="ng-scope ng-binding">'+i+'</option>';
    }
    return optionTag;
}
var changeKidAge = function(id,value)
{
    sessionStorage.setItem(id,value);
}
var changeLoadSetKidAge = function(total)
{
    $count_alter=0;
    var request_people_alterKind;
    for(var i=1;i<=total;i++)
    {
        if(sessionStorage.getItem('kid_age_'+i+'')!= null)
        {
            $('select#kid_age_load_'+i+'').val(sessionStorage.getItem('kid_age_'+i+''));
            if($count_alter==0)
            {
                $('.request_people_alterKind').append("("+sessionStorage.getItem('kid_age_'+i+''));
                sessionStorage.setItem('request_people_alterKind',sessionStorage.getItem('kid_age_'+i+''));
            }
            else
            {
                $('.request_people_alterKind').append(","+sessionStorage.getItem('kid_age_'+i+''));
                request_people_alterKind = sessionStorage.getItem('request_people_alterKind')+","+sessionStorage.getItem('kid_age_'+i+'');
                sessionStorage.setItem('request_people_alterKind',request_people_alterKind);
            }
            //$('.request_people_alterKind').html("("+sessionStorage.getItem('kid_age_'+i+'')+")");
            
            //sessionStorage.setItem('request_people_alterKind',sessionStorage.getItem('kid_age_'+i+''));
            $count_alter=$count_alter+1;
        }
    }
    $('.request_people_alterKind').append(")");    
}

var changeSubmitSetKidAge = function(total)
{
    var kid_age_alter;
    for(var i=1;i<=total;i++)
    {
        kid_age_alter = $("select#kid_age_load_"+i).val();
        sessionStorage.setItem('kid_age_'+i+'',kid_age_alter);
    }    
}

$( document ).ready(function() {
  $("div.contentBoxFooterNav-item a.link").click(function() {
        parent.history.back();
        return false;
    });
});

$.urlParam = function(name){
    //var results = new RegExp('[\?&amp;]' + name + '=([^&amp;#]*)').exec(window.location.href);
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);

    return results == null ? 0 : (results[1] || 0);
}

var travelRequest = angular.module('travelRequest', ['ngCookies']);
travelRequest.controller('RequestType', ['$scope', function ($scope) {
    if(sessionStorage.getItem('travel_item')!= null)
    {
        $scope.travel_item=sessionStorage.getItem('travel_item');   
    }
    else
    {
        $scope.travel_item=1;
        sessionStorage.setItem('travel_item',1); 
    }
    $("li.itinerary-li span.itinerary-span span.itinerary-span-"+$scope.travel_item).removeClass("display-none");
    $("li.requires-request-"+$scope.travel_item).addClass("display-none");
    if(sessionStorage.getItem('travel_item')==3)
    {
        $("div.contentBox-section nav.contentBoxTabs ul.contentBoxTabs-list li:nth-child(5)").removeClass("display-none");
    }
    else
    {
        $("div.contentBox-section nav.contentBoxTabs ul.contentBoxTabs-list li:nth-child(4)").removeClass("display-none");
    }

    $scope.changeRequestType = function() {
        sessionStorage.setItem('travel_item',$scope.travel_item);
        travel_item = sessionStorage.getItem('travel_item');    // Get cookie
        //window.location.reload();
        location.href="?section=travellers";
    }
}]);


travelRequest.filter('kid', function() {
    return function(input) {
        return 'Alter ' + input + '. Kind';
    };
});

travelRequest.controller('RequestTab', ['$scope', function ($scope) {
    //alert("Works for Moneday"+$.urlParam('section'));
    var pathname;
    $scope.tabIconFilled = function(tab) 
    {
        if(sessionStorage.getItem(''+tab+'_menu')!= null)
        {
            pathname = window.location.pathname+"?section=";
            $("nav.contentBoxTabs ul.contentBoxTabs-list li."+tab+"-li i.tabIcon-"+tab+"").addClass("tabIcon-"+tab+"--filled");
            $("nav.contentBoxTabs ul.contentBoxTabs-list li."+tab+"-li a").attr("href", ""+pathname+""+tab+"");
            $("nav.contentBoxTabs ul.contentBoxTabs-list li."+tab+"-li span."+tab+"-span").addClass("contentBoxTabs-item-label--filled");
        }
    }
    var urlPara;
    if ($.urlParam('section'))
    {
        urlPara = $.urlParam('section');
    }
    else
    {
        urlPara = 'travellers';
    }
    if(sessionStorage.getItem('travellers_menu'))
    {
        $scope.tabIconFilled('travellers');
    }
    if(sessionStorage.getItem('itinerary_menu'))
    {
        $scope.tabIconFilled('itinerary');
    }
    if(sessionStorage.getItem('dates_menu'))
    {
        $scope.tabIconFilled('dates');
    }
    if(sessionStorage.getItem('accommodation_menu'))
    {
        $scope.tabIconFilled('accommodation');
    }
        if(sessionStorage.getItem('flight_details_menu'))
    {
        $scope.tabIconFilled('flight_details');
    }
    if(sessionStorage.getItem('overview_menu'))
    {
        $scope.tabIconFilled('overview');
    }
    
    //sessionStorage.getItem('itinerary_menu',1);
    //$scope.tabIconFilled('travellers');  // This section would be dynamic and have done by for loop
    $("nav.contentBoxTabs ul.contentBoxTabs-list li."+urlPara+"-li").addClass("contentBoxTabs-item--current");
    $("nav.contentBoxTabs ul.contentBoxTabs-list li."+urlPara+"-li i.tabIcon-"+urlPara+"").addClass("tabIcon-"+urlPara+"--current");
    $("nav.contentBoxTabs ul.contentBoxTabs-list li."+urlPara+"-li span."+urlPara+"-span").addClass("contentBoxTabs-item-label--current");
    $("nav.contentBoxTabs ul.contentBoxTabs-list li."+urlPara+"-li i.tabIcon-"+urlPara+"").removeClass("tabIcon-"+urlPara+"--filled");
    $("nav.contentBoxTabs ul.contentBoxTabs-list li."+urlPara+"-li span."+urlPara+"-span").removeClass("contentBoxTabs-item-label--filled");
    $("div.contentBoxMain-section div.contentBox-"+urlPara+"-section").removeClass("display-none");
    
}]);

travelRequest.controller('Travellers', ['$scope', function ($scope) {
    $scope.data = {
        number_of_adults: 1,
        number_of_kids: 0,
        kid_number_age: 1,
        kid_age: [],
        input_num: []
    };

    if(sessionStorage.getItem('number_of_adults')!= null)
    {
        $scope.data.number_of_adults=sessionStorage.getItem('number_of_adults');   
    }
    else
    {
        $scope.data.number_of_adults=1; 
    }

    if(sessionStorage.getItem('number_of_kids')!= null)
    {
        $scope.data.number_of_kids=sessionStorage.getItem('number_of_kids');
        var alter_kid;
        var alter_kid_tag;
        for (var i=1; i<=$scope.data.number_of_kids; i++)
        {
            alter_kid='Alter ' + i + '. Kind';
            alter_kid_tag = rangeDetector(18);            
            $("#alter_kid").append('<li class="form-row ng-scope" ng-repeat="(index,age) in data.kid_age"><label class="form-lb ng-binding" for="kid_age">'+alter_kid+'</label><div class="form-ct"><select name="kid_age[]" class="input" id="kid_age_load_'+i+'" onchange="changeKidAge(this.id,this.value);">'+alter_kid_tag+'</select></div></li>');

        }

    }
    else
    {
        $scope.data.number_of_kids=0; 
    }

    changeLoadSetKidAge(4);

    $scope.changeNumberOfAdults = function() 
    {
        //sessionStorage.setItem('number_of_adults',$scope.data.number_of_adults);
        numberOfAdults = sessionStorage.getItem('number_of_adults');    // Get cookie
    }
    $scope.changeKidNumber = function()
    {

        $("ul#alter_kid").empty();
        //sessionStorage.setItem('number_of_kids',$scope.data.number_of_kids);
        numberOfAdults = sessionStorage.getItem('number_of_kids');    // Get cookie
        $scope.data.kid_age = [];

        for(var i = 0; i < $scope.data.number_of_kids; i++)
        {
            $scope.data.kid_age[i] = i;
            $scope.range(18);
        }

        var j=0;
        setTimeout(function(){
        for(var i = 0; i < $scope.data.number_of_kids; i++)
        {
            j = i + 1;
            if(sessionStorage.getItem('kid_age_'+j+'')!= null)
            {
                $('select#kid_age_'+j+'').val(sessionStorage.getItem('kid_age_'+j+''));
            }
        }
    }, 1000);
    }
    $scope.travellersForm = function()
    {
        sessionStorage.setItem('number_of_adults',$scope.data.number_of_adults);
        sessionStorage.setItem('number_of_kids',$scope.data.number_of_kids);
        sessionStorage.setItem('travellers_menu',1);
        sessionStorage.setItem('itinerary_menu',1);
        changeSubmitSetKidAge($scope.data.number_of_kids);        
        location.href="?section=itinerary";
    }

    $scope.range = function(total) {
        total = parseInt(total);
        for (var i=0; i<total; i++)
        {
                $scope.data.input_num[i]=i;
        }
    }   
}]);

travelRequest.controller('Itinerary', ['$scope', function ($scope) {
    var requiresItem;
    if(sessionStorage.getItem('travel_item')==1)
    {
        $("#number_of_departure").val(sessionStorage.getItem('number_of_departure'));
        $("#number_of_wantGo").val(sessionStorage.getItem('number_of_wantGo'));
        $("#number_of_except").val(sessionStorage.getItem('number_of_except'));

        $("#requestLocation").html(sessionStorage.getItem('number_of_wantGo'));
        $("#requestFrom").html("From "+sessionStorage.getItem('number_of_departure'));
        $("#requestExcept").html("Except "+sessionStorage.getItem('number_of_except'));

        $("#number_of_departure").prop('required',true);
        $("#number_of_wantGo").prop('required',true);
    }
    else if(sessionStorage.getItem('travel_item')==2)
    {
        $("#number_of_wantGo").val(sessionStorage.getItem('number_of_wantGo'));
        $("#number_of_except").val(sessionStorage.getItem('number_of_except'));

        $("#requestLocation").html(sessionStorage.getItem('number_of_wantGo'));
        $("#requestExcept").html("Except "+sessionStorage.getItem('number_of_except'));

        $("#number_of_wantGo").prop('required',true);
    }
    else if(sessionStorage.getItem('travel_item')==3)
    {
        if(sessionStorage.getItem('requiresItem')!= null)
        {
            $scope.requiresItem=sessionStorage.getItem('requiresItem');   
        }
        else
        {
            $scope.requiresItem=1; 
        }

        if(sessionStorage.getItem('requiresItem')==1)
        {
            $("#requestLocation").html(sessionStorage.getItem('departure')+" --> "+sessionStorage.getItem('destination'));
        }
        else if(sessionStorage.getItem('requiresItem')==2)
        {
            $("#requestLocation").html(sessionStorage.getItem('departure_arrival')+" --> "+sessionStorage.getItem('destination_e'));
        }
        else if(sessionStorage.getItem('requiresItem')==3)
        {
            $("#requestLocation").html(sessionStorage.getItem('departure')+" --> "+sessionStorage.getItem('destination_e_stops')+" --> "+sessionStorage.getItem('ultimate_goal_return_location'));
        }

        
        $("li.requires-request-3_"+$scope.requiresItem).removeClass("display-none");
        $("li.requires-request-3_"+$scope.requiresItem+" input.pre").prop('required',true);

        if(sessionStorage.getItem('departure'))
        {
            $("#departure").val(sessionStorage.getItem('departure'));
        }
        if(sessionStorage.getItem('destination'))
        {
            $("#destination").val(sessionStorage.getItem('destination'));
        }
        if(sessionStorage.getItem('departure_arrival'))
        {
            $("#departure_arrival").val(sessionStorage.getItem('departure_arrival'));
        }
        if(sessionStorage.getItem('destination_e'))
        {
            $("#destination_e").val(sessionStorage.getItem('destination_e'));
        }
        if(sessionStorage.getItem('destination_e_stops'))
        {
            $("#destination_e_stops").val(sessionStorage.getItem('destination_e_stops'));
        }
        if(sessionStorage.getItem('ultimate_goal_return_location'))
        {
            $("#ultimate_goal_return_location").val(sessionStorage.getItem('ultimate_goal_return_location'));
        }

        /*
        if(sessionStorage.getItem('number_of_departure'))
        {
            $("#number_of_departure").val(sessionStorage.getItem('number_of_departure'));
        }
        if(sessionStorage.getItem('number_of_wantGo'))
        {
            $("#number_of_wantGo").val(sessionStorage.getItem('number_of_wantGo'));
        }
        if(sessionStorage.getItem('number_of_except'))
        {
            $("#number_of_except").val(sessionStorage.getItem('number_of_except'));
        }
        */
    }
    
    $scope.itineraryForm = function()
    {
        //alert(8);
        if(sessionStorage.getItem('requiresItem')==null)
        {
            sessionStorage.setItem('requiresItem',1);
        }
        //alert($("#departure").val());
        sessionStorage.setItem('departure',$("#departure").val());
        sessionStorage.setItem('destination',$("#destination").val());
        sessionStorage.setItem('departure_arrival',$("#departure_arrival").val());
        sessionStorage.setItem('destination_e',$("#destination_e").val());
        sessionStorage.setItem('destination_e_stops',$("#destination_e_stops").val());
        sessionStorage.setItem('ultimate_goal_return_location',$("#ultimate_goal_return_location").val());

        sessionStorage.setItem('number_of_departure',$("#number_of_departure").val());
        sessionStorage.setItem('number_of_wantGo',$("#number_of_wantGo").val());
        sessionStorage.setItem('number_of_except',$("#number_of_except").val());
        sessionStorage.setItem('travellers_menu',1);
        sessionStorage.setItem('itinerary_menu',1);
        sessionStorage.setItem('dates_menu',1);
        location.href="?section=dates";
    }
    $scope.changeRequiresType = function() {
        //alert(1);
        sessionStorage.setItem('requiresItem',$scope.requiresItem);
        requiresItem = sessionStorage.getItem('requiresItem');    // Get cookie
        window.location.reload();
    }
}]);

travelRequest.controller('Dates', ['$scope', function ($scope) {
    
    $scope.data = {
            duration_type: 'fix',
            duration_from: 1,
            duration_to: 1,
            duration_unit: "days",
            earliest_at: moment().format('DD-MM-YYYY'),
            latest_at: moment().add('days', 7).format('DD-MM-YYYY'),
            input_num: []
        };

    for (var i=1; i<15; i++)
    {
            $scope.data.input_num[i-1]=i;
    }

    if(sessionStorage.getItem('duration_type')!=null)
    {
        $scope.data.duration_type = sessionStorage.getItem('duration_type');
        $scope.data.duration_from = sessionStorage.getItem('duration_from');
        $scope.data.duration_to = sessionStorage.getItem('duration_to');
        $scope.data.duration_unit = sessionStorage.getItem('duration_unit');
        $scope.data.earliest_at = sessionStorage.getItem('earliest_at');
        $scope.data.latest_at = sessionStorage.getItem('latest_at');
        
    }

    if(sessionStorage.getItem('travel_item')==3)
    {
        if(sessionStorage.getItem('requiresItem')!=1)
        {
            $("div.contentBox-dates-section form ul li:nth-child(1)").removeClass("display-none");
            $("div.contentBox-dates-section form ul li:nth-child(2)").removeClass("display-none");
        }
    }
    else
    {
        $("div.contentBox-dates-section form ul li:nth-child(1)").removeClass("display-none");
        $("div.contentBox-dates-section form ul li:nth-child(2)").removeClass("display-none");
    }
    $scope.datesForm = function()
    {
        sessionStorage.setItem('duration_type',$scope.data.duration_type);
        sessionStorage.setItem('duration_from',$scope.data.duration_from);
        sessionStorage.setItem('duration_to',$scope.data.duration_to);
        sessionStorage.setItem('duration_unit',$scope.data.duration_unit);
        sessionStorage.setItem('earliest_at',$("#earliest_at").val());
        sessionStorage.setItem('latest_at',$("#latest_at").val());
        sessionStorage.setItem('travellers_menu',1);
        sessionStorage.setItem('itinerary_menu',1);
        sessionStorage.setItem('dates_menu',1);
        if(sessionStorage.getItem('travel_item')==3)
        {
            sessionStorage.setItem('flight_details_menu',1);
            location.href="?section=flight_details";
        }
        else
        {
            sessionStorage.setItem('accommodation_menu',1);
            location.href="?section=accommodation";
        }
    }
    
}]);

travelRequest.controller('Accommodation', ['$scope', function ($scope) {
    
    $scope.data = {
            price_level: 'normal',
            accommodation_type: 'Hotels and Apartments',
            minimum_category: 3,
            board: 'Give a damn',
            tripadvisor_score: 30,
            wlan: false,
            holidaycheck_score: '80',
            notes: ''
            
        };

    if(sessionStorage.getItem('travel_item')==2)
    {
     $(".contentBox-accommodation-section ul li:nth-child(2)").removeClass("display-none");
     $(".contentBox-accommodation-section ul li:nth-child(3)").removeClass("display-none");
     $(".contentBox-accommodation-section ul li:nth-child(5)").removeClass("display-none");
     $(".contentBox-accommodation-section ul li:nth-child(6)").removeClass("display-none");
    }
    else
    {
     $(".contentBox-accommodation-section ul li:nth-child(1)").removeClass("display-none");
     $(".contentBox-accommodation-section ul li:nth-child(7)").removeClass("display-none");             
    }
    if(sessionStorage.getItem('price_level')!=null)
    {
        $scope.data.price_level = sessionStorage.getItem('price_level');
        
        $scope.data.accommodation_type = sessionStorage.getItem('accommodation_type');
        $scope.data.minimum_category = sessionStorage.getItem('minimum_category');

        $scope.data.board = sessionStorage.getItem('board');

        $scope.data.tripadvisor_score = sessionStorage.getItem('tripadvisor_score');
        if(sessionStorage.getItem('wlan')=='true')
        {
        $scope.data.wlan = true;
        }

        $scope.data.holidaycheck_score = sessionStorage.getItem('holidaycheck_score');
        $scope.data.notes = sessionStorage.getItem('notes');
    }
    
    $scope.accommodationForm = function()
    {
        sessionStorage.setItem('price_level',$scope.data.price_level);
        
        sessionStorage.setItem('accommodation_type',$scope.data.accommodation_type);
        sessionStorage.setItem('minimum_category',$scope.data.minimum_category);

        sessionStorage.setItem('board',$scope.data.board);

        sessionStorage.setItem('tripadvisor_score',$scope.data.tripadvisor_score);
        sessionStorage.setItem('wlan',$scope.data.wlan);

        sessionStorage.setItem('holidaycheck_score',$scope.data.holidaycheck_score);
        sessionStorage.setItem('notes',$scope.data.notes);
        sessionStorage.setItem('travellers_menu',1);
        sessionStorage.setItem('itinerary_menu',1);
        sessionStorage.setItem('dates_menu',1);
        sessionStorage.setItem('accommodation_menu',1);
        sessionStorage.setItem('overview_menu',1);
        location.href="?section=overview";
    }
    
}]);

travelRequest.controller('FlightDetails', ['$scope', function ($scope) {
    
    $scope.data = {
            clas: 'Economy class',
            airline_type: 'I am all right.',
            railfly: false,
            nearby_airports: false,
            multistops: false,
            collect_miles: false            
        };

    if(sessionStorage.getItem('clas'))
    {
       $scope.data.clas = sessionStorage.getItem('clas');
       $scope.data.airline_type = sessionStorage.getItem('airline_type');
       $scope.data.railfly = sessionStorage.getItem('railfly');
       $scope.data.nearby_airports = sessionStorage.getItem('nearby_airports');
       $scope.data.multistops = sessionStorage.getItem('multistops');
       $scope.data.collect_miles = sessionStorage.getItem('collect_miles');
    }
        
    $scope.flightDetailsForm = function()
    {
        sessionStorage.setItem('clas',$scope.data.clas);
        sessionStorage.setItem('airline_type',$scope.data.airline_type);
        sessionStorage.setItem('railfly',$scope.data.railfly);
        sessionStorage.setItem('nearby_airports',$scope.data.nearby_airports);
        sessionStorage.setItem('multistops',$scope.data.multistops);
        sessionStorage.setItem('collect_miles',$scope.data.collect_miles);

        sessionStorage.setItem('travellers_menu',1);
        sessionStorage.setItem('itinerary_menu',1);
        sessionStorage.setItem('dates_menu',1);
        sessionStorage.setItem('flight_details_menu',1);
        sessionStorage.setItem('overview_menu',1);
        location.href="?section=overview";
    }
    
}]);

travelRequest.controller('Overview', ['$scope', function ($scope) {
    
    $scope.data = {
        request_title: null,
        request_details: null,
        request_description: null,
        request_budget: 0,
        currency: 'currency_eur',
        unit_type: 'per person',
        confirm_updates: false,
        request_people_alterKind_hid: sessionStorage.getItem('request_people_alterKind'),
        travel_item_hid: sessionStorage.getItem('travel_item'),
        number_of_adults_hid: sessionStorage.getItem('number_of_adults'),
        number_of_kids_hid: sessionStorage.getItem('number_of_kids'),
        departure_hid: sessionStorage.getItem('departure'),
        destination_hid: sessionStorage.getItem('destination'),
        departure_arrival_hid: sessionStorage.getItem('departure_arrival'),
        destination_e_hid: sessionStorage.getItem('destination_e'),
        destination_e_stops_hid: sessionStorage.getItem('destination_e_stops'),
        ultimate_goal_return_location_hid: sessionStorage.getItem('ultimate_goal_return_location'),
        number_of_departure_hid: sessionStorage.getItem('number_of_departure'),
        number_of_wantGo_hid: sessionStorage.getItem('number_of_wantGo'),
        number_of_except_hid: sessionStorage.getItem('number_of_except'),
        requiresItem_hid: sessionStorage.getItem('requiresItem'),
        duration_type_hid: sessionStorage.getItem('duration_type'),
        duration_from_hid: sessionStorage.getItem('duration_from'),
        duration_to_hid: sessionStorage.getItem('duration_to'),
        duration_unit_hid: sessionStorage.getItem('duration_unit'),
        earliest_at_hid: sessionStorage.getItem('earliest_at'),
        latest_at_hid: sessionStorage.getItem('latest_at'),        
        clas_hid: sessionStorage.getItem('clas'),
        airline_type_hid: sessionStorage.getItem('airline_type'),
        railfly_hid: sessionStorage.getItem('railfly'),
        nearby_airports_hid: sessionStorage.getItem('nearby_airports'),
        multistops_hid: sessionStorage.getItem('multistops'),
        collect_miles_hid: sessionStorage.getItem('collect_miles'),
        price_level_hid: sessionStorage.getItem('price_level'),
        accommodation_type_hid: sessionStorage.getItem('accommodation_type'),
        minimum_category_hid: sessionStorage.getItem('minimum_category'),
        board_hid: sessionStorage.getItem('board'),
        tripadvisor_score_hid: sessionStorage.getItem('tripadvisor_score'),
        wlan_hid: sessionStorage.getItem('wlan'),
        holidaycheck_score_hid: sessionStorage.getItem('holidaycheck_score'),
        notes_hid: sessionStorage.getItem('notes')
    };

    if(sessionStorage.getItem('request_title')!=null)
    {
        $scope.data.request_title = sessionStorage.getItem('request_title');
        $scope.data.request_details = sessionStorage.getItem('request_details');
        $scope.data.request_description = sessionStorage.getItem('request_description');
        $scope.data.request_budget = sessionStorage.getItem('request_budget');
        $scope.data.currency = sessionStorage.getItem('currency');
        $scope.data.unit_type = sessionStorage.getItem('unit_type');
        $scope.data.confirm_updates = sessionStorage.getItem('confirm_updates');
    }

    $(".request-date-range").html(""+sessionStorage.getItem('earliest_at')+" - "+sessionStorage.getItem('latest_at')+"");
    $(".request-people").html(sessionStorage.getItem('number_of_adults')+"adult and "+sessionStorage.getItem('number_of_kids')+" child");
    $(".request-package-type").html(sessionStorage.getItem('price_level'));
    //$(".request-description").html(sessionStorage.getItem('board')+". Near: "+sessionStorage.getItem('notes')+" Min. Holiday Recommendation: "+sessionStorage.getItem('holidaycheck_score')+"%");


        if(sessionStorage.getItem('travel_item')==3)
        {
            if(sessionStorage.getItem('railfly'))
            {
                $scope.data.request_details='I want to use Rail & Fly.';
            }
            if(sessionStorage.getItem('nearby_airports'))
            {
                $scope.data.request_details=$scope.data.request_details+'Area Airports are ok.';
            }
            if(sessionStorage.getItem('multistops'))
            {
                $scope.data.request_details=$scope.data.request_details+'Stopovers are ok, if it saves money.';
            }
            if(sessionStorage.getItem('collect_miles'))
            {
                $scope.data.request_details=$scope.data.request_details+'I collect miles.';
            }

            //alert($scope.data.request_details);
            $(".request-details").html($scope.data.request_details);
            $("div#preview article").removeClass("request--tr").addClass("request--fl");
            var requiresItemHtml;
            //alert(sessionStorage.getItem('requiresItem'));
            if(sessionStorage.getItem('requiresItem')==1)
            {
                requiresItemHtml='One Way';
            }
            else if(sessionStorage.getItem('requiresItem')==2)
            {
                requiresItemHtml='Return';
            }
            else if(sessionStorage.getItem('requiresItem')==3)
            {
                requiresItemHtml='Gabelflug';
            }
            $("div.request-package-duration").html(requiresItemHtml+"("+sessionStorage.getItem('clas')+")");
            $("div.request-main-content div.request-package-type").removeClass("request-package-type").addClass("request-flight-details");
            $(".request-flight-details").html(sessionStorage.getItem('airline_type'));
        }
        else
        {
            $(".request-details").html(sessionStorage.getItem('board')+". Near: "+sessionStorage.getItem('notes')+" Min. Holiday Recommendation: "+sessionStorage.getItem('holidaycheck_score')+"%");
        }

    $scope.countChar = function(id,limit)
    {
        var val = $("#"+id).val();
        var len = val.length;
        if (len >= limit) {
          $("#"+id).val(val.substring(0, limit));
        } else {
         $("#"+id).siblings("span.form-nfoI").text((limit - len)+"/"+limit);
         //$('#charNum').text(500 - len);
        }
    };

    $scope.overviewForm = function()
    {
        
        sessionStorage.setItem('request_title',$scope.data.request_title);
        sessionStorage.setItem('request_details',$scope.data.request_details);

        sessionStorage.setItem('request_description',$scope.data.request_description);
        sessionStorage.setItem('request_budget',$scope.data.request_budget);
        sessionStorage.setItem('currency',$scope.data.currency);
        sessionStorage.setItem('unit_type',$scope.data.unit_type);
        sessionStorage.setItem('confirm_updates',$scope.data.confirm_updates);
        


        $("#request_people_alterKind_hid").val(sessionStorage.getItem('request_people_alterKind'));
        $("#travel_item_hid").val(sessionStorage.getItem('travel_item'));
        $("#number_of_adults_hid").val(sessionStorage.getItem('number_of_adults'));
        $("#number_of_kids_hid").val(sessionStorage.getItem('number_of_kids'));
        $("#departure_hid").val(sessionStorage.getItem('departure'));
        $("#destination_hid").val(sessionStorage.getItem('destination'));
        $("#departure_arrival_hid").val(sessionStorage.getItem('departure_arrival'));
        $("#destination_e_hid").val(sessionStorage.getItem('destination_e'));
        $("#destination_e_stops_hid").val(sessionStorage.getItem('destination_e_stops'));
        $("#ultimate_goal_return_location_hid").val(sessionStorage.getItem('ultimate_goal_return_location'));
        $("#number_of_departure_hid").val(sessionStorage.getItem('number_of_departure'));
        $("#number_of_wantGo_hid").val(sessionStorage.getItem('number_of_wantGo'));
        $("#number_of_except_hid").val(sessionStorage.getItem('number_of_except'));
        $("#requiresItem_hid").val(sessionStorage.getItem('requiresItem'));
        $("#duration_type_hid").val(sessionStorage.getItem('duration_type'));
        $("#duration_from_hid").val(sessionStorage.getItem('duration_from'));
        $("#duration_to_hid").val(sessionStorage.getItem('duration_to'));
        $("#duration_unit_hid").val(sessionStorage.getItem('duration_unit'));
        $("#earliest_at_hid").val(sessionStorage.getItem('earliest_at'));
        $("#latest_at_hid").val(sessionStorage.getItem('latest_at'));
        $("#clas_hid").val(sessionStorage.getItem('clas'));
        $("#airline_type_hid").val(sessionStorage.getItem('airline_type'));
        $("#railfly_hid").val(sessionStorage.getItem('railfly'));
        $("#nearby_airports_hid").val(sessionStorage.getItem('nearby_airports'));
        $("#multistops_hid").val(sessionStorage.getItem('multistops'));
        $("#collect_miles_hid").val(sessionStorage.getItem('collect_miles'));                        
        $("#price_level_hid").val(sessionStorage.getItem('price_level'));
        
        $("#accommodation_type_hid").val(sessionStorage.getItem('accommodation_type'));
        $("#minimum_category_hid").val(sessionStorage.getItem('minimum_category'));

        $("#board_hid").val(sessionStorage.getItem('board'));

        $("#tripadvisor_score_hid").val(sessionStorage.getItem('tripadvisor_score'));
        $("#wlan_hid").val(sessionStorage.getItem('wlan'));

        $("#holidaycheck_score_hid").val(sessionStorage.getItem('holidaycheck_score'));
        $("#notes_hid").val(sessionStorage.getItem('notes'));

    }

}]);

    var loginClick = function()
    {
        $("div.login-register-span span:nth-child(1)").addClass("display-none");
        $("div.login-register-span span:nth-child(2)").removeClass("display-none");

        $("div.user-login").addClass("display-none");
        $("div.user-register").removeClass("display-none");
        
    }

    var registerClick = function()
    {
        $("div.login-register-span span:nth-child(1)").removeClass("display-none");
        $("div.login-register-span span:nth-child(2)").addClass("display-none");

        $("div.user-login").removeClass("display-none");
        $("div.user-register").addClass("display-none");
        
    }