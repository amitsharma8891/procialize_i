/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

(function($) {

    $.fn.userName = function(options) {
        var self = this;
        var username = '';
        var error = false;
        var defaults = {
            url: 'http://localhost/project-procialize/solution/ajax/unique_user'
        }
        var settings = $.extend({}, defaults, options);

        return this.each(function() {

            bindEvent();
        });

        function bindEvent() {
            $(self).on('keyup', function() {
                clearTimeout($.data(this, 'timer'));
                username = $(self).val();
                var wait = setTimeout(ajaxRequest, 500);
                $(this).data('timer', wait);


            });
        }

        function ajaxRequest() {
            if (username != '') {
                $.ajax({
                    url: settings.url,
                    data: {username: username},
                    type: 'POST',
                    dataType: 'json',
                }).done(checkAvailability);
            }
        }

        function checkAvailability(data) {
            if (data.status) {
                error = true;
                addMessage(data, true);
            } else {
                if (error) {
                    error = false;
                    RemoveError();
                }
            }
        }

        function addMessage(data) {
            RemoveError();
            $(self).after('<span class="unique_error">' + data.message + '</span>');
        }

        function RemoveError() {
            $(self).next().remove();
        }


    }
}(jQuery))