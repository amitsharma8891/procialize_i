/* 
 * Notification dropdown js
 * @author Aatish Gore
 */

var Notification = function() {
    var self = this;
    this.ajax_flag = true;
    this.clickClass = '.notificationSection';
    this.containerClass = '.notificationSection_main';
    this.data;
    this.domain = 'http://'+window.location.hostname+'/project-procialize/solution/';
    this.url = this.domain + 'manage/notification/getAll/json/';
    this.setTimevariable;
    this.prevReadCount = 0;
    this.displayCount = '.notificationCount';

    this.init = function() {
        
        this.bindToggle();
        this.getData('no');

    }

    this.setClickClass = function(className) {
        this.clickClass = className;
    }

    this.setContainer = function(className) {
        this.containerClass = className;
    }


    this.bindToggle = function() {
       
       
        $(this.clickClass).on('click', function() {
//            $(self.containerClass).fadeToggle('slow');
            if (self.ajax_flag) {
                
                self.getData('yes');
                
                self.ajax_flag = false;
            }
        });
    }


    this.getData = function(readIndicator) {
      
        $.ajax({
            //            async: false, //thats the trick
            url: self.url+readIndicator,
            dataType: 'json',
            contentType: "application/json; charset=utf-8",
            type: 'GET'
        }).done(self.ajaxDataProcessor);
    }

    this.ajaxDataProcessor = function(data) {
        
       
        self.processTemplate(data);
        self.clearCheckTime();
        self.setTimevariable = setInterval(function() {
            self.ajax_flag = true;
            self.getData('no');
        }, 600000); //600000
        
        
        if(self.prevReadCount != data.unread){ 
            $(self.displayCount).html(data.unread);
            self.prevReadCount = data.unread;
        }else{
                self.prevReadCount = 0;
             $(self.displayCount).html(0);
            
        }
    }


    this.processTemplate = function(data) {
        console.log(data);
        var compiledTemplate = _.template($("#notification_content").html(), {
            content: data.notifications.splice(0, 5)
        });
        $(this.containerClass).html(compiledTemplate);

    }

    this.clearCheckTime = function() {
        clearInterval(this.setTimevariable);
    }


}

$(document).ready(function() {
    var newObjNotification = new Notification();
    newObjNotification.init();
});


    