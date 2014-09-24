/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

(function($) {

    $.fn.googleAutocomplete = function(options) {
         var self = this;
        var defaults = {
            txtLatitude: 'latitude',
            txtLongitude: 'longitude',
        }
       var settings = $.extend({}, defaults, options);

        return this.each( function() {
          
            var options = {};
            var autocomplete = new google.maps.places.Autocomplete(this,options);
            var infoWindow = new google.maps.InfoWindow();
            google.maps.event.addListener(autocomplete, 'place_changed', function() {
                var place = autocomplete.getPlace();
                document.getElementsByName(settings.txtLatitude)[0].value = place.geometry.location.lat();
                document.getElementsByName(settings.txtLongitude)[0].value = place.geometry.location.lng();
                
            });
        });
    }
}(jQuery))
