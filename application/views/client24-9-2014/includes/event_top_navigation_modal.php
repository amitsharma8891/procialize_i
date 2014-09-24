
<!----SEND MESSAGE TO USER----->
<style type="text/css">
.default{width:220px !important;}
.ui-autocomplete{z-index: 999999;display: block}
</style>
<div id="new_msg"  class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">New Message</h4>
            </div>
      
        <div class="modal-body">
            <form class="form-horizontal" id="send_message_form"  role="form" onsubmit="return false;">
                <div class="form-group">
                    <p>To: <?php echo $target_user_name;?></p>
                    <!--<select id="mulitple_attendee"  name="mulitple_attendee[]" multiple   class="form-control chosen-select" placeholder="Add Attendee,Speaker,Exhibitor" data-placeholder="Add Attendee,Speaker,Exhibitor">
                        <?php 
                            /*$event_id       = $this->session->userdata('client_event_id');
                            $attendee_list                                          = $this->client_event_model->getActiveAttendee($event_id);
                            if($attendee_list)
                            {
                                foreach($attendee_list as $att)
                                {
                                    if($att['attendee_type'] == 'A')
                                        $attendee_type = 'Attendee';
                                    elseif($att['attendee_type'] == 'E')
                                        $attendee_type = 'Exhibitor';
                                    elseif($att['attendee_type'] == 'S')
                                        $attendee_type = 'Speaker';
                                    if($att['id'] != $this->session->userdata('client_attendee_id'))
                                    echo '<option  value="'.$att['id'].'">'.  ucwords(strtolower ($att['name'])).' ('.$attendee_type.')</option>';
                                }
                            }*/
                        ?>
                    </select>-->
                    <script type="text/javascript">
                        $(function() {
                            function split( val ) {
                              return val.split( /,\s*/ );
                            }
                            function extractLast( term ) {
                              return split( term ).pop();
                            }

                            $( "#search_all_user" )
                              // don't navigate away from the field on tab when selecting an item
                              .bind( "keydown", function( event ) {
                                if ( event.keyCode === $.ui.keyCode.TAB &&
                                    $( this ).autocomplete( "instance" ).menu.active ) {
                                  event.preventDefault();
                                }
                              })
                              .autocomplete({
                                source: function( request, response ) {
                                  $.getJSON( SITE_URL+"client/event/get_all_user", {
                                    term: extractLast( request.term )
                                  }, response );
                                 
                                },
                                search: function() {
                                  // custom minLength
                                  var term = extractLast( this.value );
                                  if ( term.length < 2 ) {
                                    return false;
                                  }
                                },
                                focus: function() {
                                  // prevent value inserted on focus
                                  return false;
                                },
                                select: function( event, ui ) {
                                  var terms = split( this.value );
                                  // remove the current input
                                  terms.pop();
                                  // add the selected item
                                  terms.push( ui.item.value );
                                  $(".addattendies").append('<input type="hidden" name="mulitple_attendee[]" id="mulitple_attendee" value="'+ui.item.id+'">');
                                  // add placeholder to get the comma-and-space at the end
                                  terms.push( "" );
                                  this.value = terms.join( ", " );
                                  
                                  return false;
                                }
                              });
                          });
                    </script>
                    
                    <input type="text" name="search_all_user" id="search_all_user" class="form-control"  placeholder="Add Attendee,Speaker,Exhibitor">
                    
                    
                    <div class="addattendies">

                    </div>
                </div>

                <div class="form-group">
                    <!--<input type="button" class="btn btn-success input-sm btn-block" value="Add" id="addmoreat">-->
                </div>
                <div class="form-group">
                    <div class="checkbox-inline">
                        <label> <input type="checkbox" name="mesaage_checkbox" id="mesaage_checkbox"> All Attendees, Speakers, Exhibitors</label>
                    </div>
                </div>
                <div class="form-group">
                    <textarea class="form-control" rows="3" name="message_text" id="message_text_val" placeholder="Write your message here"></textarea>
                     <div id="message_text_val_err" style="color: red;"></div>
                </div>
                <div class="form-group">
                    <input type="hidden" name="target_attendee_id" id="target_attendee_id" value="<?php echo $target_user_id ?>">
                    <input type="hidden" name="target_user_type" id="target_user_type" value="<?php echo $target_user_type?>">
                    <div class="loader"></div><button type="submit" id="send_message_btn" class="btn btn-success input-sm btn-block">Send</button>
                </div>
            </form>
        </div>
        
      
    </div>
  </div>
  
</div>

<!----SEND MESSAGE TO USER----->
