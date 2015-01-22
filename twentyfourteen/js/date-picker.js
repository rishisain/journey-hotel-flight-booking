(function ($){

    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

    $('[data-start-date]').prop('readonly', 'true');
    $('[data-end-date]').prop('readonly', 'true');

    var checkin = $('[data-start-date]').datepicker({
        onRender: function(date) {
            return date.valueOf() < now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
            if (ev.date.valueOf() > checkout.date.valueOf()) {
                var newDate = new Date(ev.date)
                newDate.setDate(newDate.getDate() + 7);
                checkout.setValue(newDate);
            }
            checkin.hide();
            $(this).show();
            $('[data-end-date]')[0].focus();
        }).data('datepicker');
    var checkout = $('[data-end-date]').datepicker({
        onRender: function(date) {
            return date.valueOf() < checkin.date.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
            checkout.hide();
            $(this).show();
        }).data('datepicker');
}(window.jQuery));