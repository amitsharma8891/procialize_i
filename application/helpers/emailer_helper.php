<?php

function forget_password_temp()
{
    $html           = '<html>
                    <head><title>Procialize Forget Password</title></head>
                    <body>
                        <div>
                            <table cellspacing="0" cellpadding="0" border="0" bgcolor="#ebebeb" align="center" style="max-width:600px;min-width:200px">
                                <tbody><tr>
                                        <td width="600" style="padding:10px 0px">
                                            <table width="217" cellspacing="0" cellpadding="0" border="0" align="left">
                                                <tbody><tr>
                                                        <td style="padding:14px">Hello {first_name},</td>

                                                    </tr>
                                                </tbody></table></td>
                                    </tr>
                                </tbody></table>

                            <table border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF" style="max-width:600px;min-width:320px;border:1px solid #e2e2e2">
                                <tbody><tr>
                                        <td valign="top" width="600">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tbody><tr>

                                                    </tr>
                                                    <tr>

                                                    <tr>

                                                    </tr>
                                                    <tr>

                                                    </tr><tr>
                                                        <td height="10"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><table width="90%" border="0" cellspacing="0" cellpadding="0">
                                                                <tbody><tr>
                                                                        <td width="10"></td>
                                                                        <td style="font-family:calibri;font-size:15px;color:#1b1b1b;text-align:justify;line-height:20px">
                                                                            We have received a request to reset the password for your e-mail address. 
                                                                            <br><br>Click the link mentioned below and change your password:
                                                                            <br>{password_link}
                                                                            <br><br>If you did not request to reset your password for this ID, kindly report it to admin@procialize.net 
                                                                            or ignore this email.
                                                                        </td>
                                                                        <td width="10"></td>
                                                                    </tr>
                                                                </tbody></table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center" valign="top">
                                                            <div style="width:100%"></div></td>
                                                    </tr>

                                                    <tr>
                                                        <td height="10"></td>
                                                    </tr>
                                                    <tr>
                                                        <td bgcolor="#5c884d"></td>
                                                    </tr>
                                                    <tr>
                                                        <td height="20"></td>
                                                    </tr>';
                                                    
    $html                       .= email_footer(); 
    $html                       .= '</tbody></table></td></tr></tbody></table></div></body></html>';
    
    return $html;
}

function share_procialize()
{
    $html    = '<html>
    <head><title>Procialize</title></head>
    <body>
        <div>
            <table cellspacing="0" cellpadding="0" border="0" bgcolor="#ebebeb" align="center" style="max-width:600px;min-width:200px">
                <tbody><tr>
                        <td width="600" style="padding:10px 0px">
                            <table width="217" cellspacing="0" cellpadding="0" border="0" align="left">
                                <tbody><tr>
                                        <td style="padding:14px">Proud Owner of the App,</td>

                                    </tr>
                                </tbody></table></td>
                    </tr>
                </tbody></table>

            <table border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF" style="max-width:600px;min-width:320px;border:1px solid #e2e2e2">
                <tbody><tr>
                        <td valign="top" width="600">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tbody><tr>

                                    </tr>
                                    <tr>

                                    <tr>

                                    </tr>
                                    <tr>

                                    </tr><tr>
                                        <td height="10"></td>
                                    </tr>
                                    <tr>
                                        <td><table width="90%" border="0" cellspacing="0" cellpadding="0">
                                                <tbody><tr>
                                                        <td width="10"></td>
                                                        <td style="font-family:calibri;font-size:15px;color:#1b1b1b;text-align:justify;line-height:20px">
                                                            {first_name}, shared Procialize App just now
                                                            <br><br>Cheers,
                                                            <br>Admin Team
                                                        </td>
                                                        <td width="10"></td>
                                                    </tr>
                                                </tbody></table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top">
                                            <div style="width:100%"></div></td>
                                    </tr>

                                    <tr>
                                        <td height="10"></td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#5c884d"></td>
                                    </tr>
                                    <tr>
                                        <td height="20"></td>
                                    </tr>';
    $html                       .= email_footer(); 
    $html                       .= '</tbody></table></td></tr></tbody></table></div></body></html>';
    
    return $html;
}

function share_procialize_via_email()
{
    $html    = '<html>
    <head><title>Procialize</title></head>
    <body>
        <div>
            <table cellspacing="0" cellpadding="0" border="0" bgcolor="#ebebeb" align="center" style="max-width:600px;min-width:200px">
                <tbody><tr>
                        <td width="600" style="padding:10px 0px">
                            <table width="217" cellspacing="0" cellpadding="0" border="0" align="left">
                                <tbody><tr>
                                        

                                    </tr>
                                </tbody></table></td>
                    </tr>
                </tbody></table>

            <table border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF" style="max-width:600px;min-width:320px;border:1px solid #e2e2e2">
                <tbody><tr>
                        <td valign="top" width="600">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tbody><tr>

                                    </tr>
                                    <tr>

                                    <tr>

                                    </tr>
                                    <tr>

                                    </tr><tr>
                                        <td height="10"></td>
                                    </tr>
                                    <tr>
                                        <td><table width="90%" border="0" cellspacing="0" cellpadding="0">
                                                <tbody><tr>
                                                        <td width="10"></td>
                                                        <td style="font-family:calibri;font-size:15px;color:#1b1b1b;text-align:justify;line-height:20px">
                                                            Hello,
                                                            <br><br>{mail_content}
                                                        </td>
                                                        <td width="10"></td>
                                                    </tr>
                                                </tbody></table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top">
                                            <div style="width:100%"></div></td>
                                    </tr>

                                    <tr>
                                        <td height="10"></td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#5c884d"></td>
                                    </tr>
                                    <tr>
                                        <td height="20"></td>
                                    </tr>';
    $html                       .= email_footer(); 
    $html                       .= '</tbody></table></td></tr></tbody></table></div></body></html>';
    return $html;
}



function mail_to_organizer_for_registration_request()
{
    $html  = '<html>
    <head><title>Procialize</title></head>
    <body>
        <div>
            <table cellspacing="0" cellpadding="0" border="0" bgcolor="#ebebeb" align="center" style="max-width:600px;min-width:200px">
                <tbody><tr>
                        <td width="600" style="padding:10px 0px">
                            <table width="217" cellspacing="0" cellpadding="0" border="0" align="left">
                                <tbody><tr>
                                        <td style="padding:14px">Hello {org_name},</td>

                                    </tr>
                                </tbody></table></td>
                    </tr>
                </tbody></table>

            <table border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF" style="max-width:600px;min-width:320px;border:1px solid #e2e2e2">
                <tbody><tr>
                        <td valign="top" width="600">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tbody><tr>

                                    </tr>
                                    <tr>

                                    <tr>

                                    </tr>
                                    <tr>

                                    </tr><tr>
                                        <td height="10"></td>
                                    </tr>
                                    <tr>
                                        <td><table width="90%" border="0" cellspacing="0" cellpadding="0">
                                                <tbody><tr>
                                                        <td width="10"></td>
                                                        <td style="font-family:calibri;font-size:15px;color:#1b1b1b;text-align:justify;line-height:20px">
                                                            Congratulations!
                                                            <br><br>There’s a request for registration to your Event from Procialize App. 
                                                            <br>Details of the Attendee are as follows:
                                                            <br><br>Event Name : {event_name}
                                                            <br><br>Name       : {first_name}
                                                            <br><br>Email      : {email}
                                                            <br><br>Please note that their Passcode is auto generated by the system, but not shared with them yet. 
                                                            He/she will not be able to get into the event without the passcode. Kindly, send them a mail from 
                                                            your Admin panel by searching for the name in the "Attendee" list.
                                                        </td>
                                                        <td width="10"></td>
                                                    </tr>
                                                </tbody></table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top">
                                            <div style="width:100%"></div></td>
                                    </tr>

                                    <tr>
                                        <td height="10"></td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#5c884d"></td>
                                    </tr>
                                    <tr>
                                        <td height="20"></td>
                                    </tr>';
    $html                       .= email_footer(); 
    $html                       .= '</tbody></table></td></tr></tbody></table></div></body></html>';
    
    return $html;
}

function mail_to_organizer_when_attendee_rsvp()
{
    $html = '<html>
    <head><title>Procialize</title></head>
    <body>
        <div>
            <table cellspacing="0" cellpadding="0" border="0" bgcolor="#ebebeb" align="center" style="max-width:600px;min-width:200px">
                <tbody><tr>
                        <td width="600" style="padding:10px 0px">
                            <table width="217" cellspacing="0" cellpadding="0" border="0" align="left">
                                <tbody><tr>
                                        <td style="padding:14px">Hello {org_name},</td>

                                    </tr>
                                </tbody></table></td>
                    </tr>
                </tbody></table>

            <table border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF" style="max-width:600px;min-width:320px;border:1px solid #e2e2e2">
                <tbody><tr>
                        <td valign="top" width="600">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tbody><tr>

                                    </tr>
                                    <tr>

                                    <tr>

                                    </tr>
                                    <tr>

                                    </tr><tr>
                                        <td height="10"></td>
                                    </tr>
                                    <tr>
                                        <td><table width="90%" border="0" cellspacing="0" cellpadding="0">
                                                <tbody><tr>
                                                        <td width="10"></td>
                                                        <td style="font-family:calibri;font-size:15px;color:#1b1b1b;text-align:justify;line-height:20px">
                                                            Congratulations!
                                                            <br><br>There’s a request for registration to a session in your Event from Procialize App. 
                                                            <br>Details of the Attendee are as follows:
                                                            <br><br>Session Name : {session_name}
                                                            <br>Name       : {first_name}
                                                            <br>Email      : {email}
                                                            
                                                        </td>
                                                        <td width="10"></td>
                                                    </tr>
                                                </tbody></table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top">
                                            <div style="width:100%"></div></td>
                                    </tr>

                                    <tr>
                                        <td height="10"></td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#5c884d"></td>
                                    </tr>
                                    <tr>
                                        <td height="20"></td>
                                    </tr>';
    $html                       .= email_footer(); 
    $html                       .= '</tbody></table></td></tr></tbody></table></div></body></html>';
    
    return $html;
}


function send_message_email_temp()
{
    $html = '<html>
    <head><title>Procialize</title></head>
    <body>
        <div>
            <table cellspacing="0" cellpadding="0" border="0" bgcolor="#ebebeb" align="center" style="max-width:600px;min-width:200px">
                <tbody><tr>
                        <td width="600" style="padding:10px 0px">
                            <table width="217" cellspacing="0" cellpadding="0" border="0" align="left">
                                <tbody><tr>
                                        <td style="padding:14px">Hello {subject_first_name},</td>

                                    </tr>
                                </tbody></table></td>
                    </tr>
                </tbody></table>

            <table border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF" style="max-width:600px;min-width:320px;border:1px solid #e2e2e2">
                <tbody><tr>
                        <td valign="top" width="600">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tbody><tr>

                                    </tr>
                                    <tr>

                                    <tr>

                                    </tr>
                                    <tr>

                                    </tr><tr>
                                        <td height="10"></td>
                                    </tr>
                                    <tr>
                                        <td><table width="90%" border="0" cellspacing="0" cellpadding="0">
                                                <tbody><tr>
                                                        <td width="10"></td>
                                                        <td style="font-family:calibri;font-size:15px;color:#1b1b1b;text-align:justify;line-height:20px">
                                                            {object_first_name} from <b>"{event_name}"</b> just sent you a message:
                                                            <br><br>"{msg_content}"
                                                            <br><br><a href="'.SITE_URL.'events">Click here</a> to read the message, as well as network with other attendees at this event
                                                        </td>
                                                        <td width="10"></td>
                                                    </tr>
                                                </tbody></table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top">
                                            <div style="width:100%"></div></td>
                                    </tr>

                                    <tr>
                                        <td height="10"></td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#5c884d"></td>
                                    </tr>
                                    <tr>
                                        <td height="20"></td>
                                    </tr>';
    $html                       .= email_footer(); 
    $html                       .= '</tbody></table></td></tr></tbody></table></div></body></html>';
    
    return $html;
}

function setup_meeting_email_temp()
{
    $html = '<html>
    <head><title>Procialize</title></head>
    <body>
        <div>
            <table cellspacing="0" cellpadding="0" border="0" bgcolor="#ebebeb" align="center" style="max-width:600px;min-width:200px">
                <tbody><tr>
                        <td width="600" style="padding:10px 0px">
                            <table width="217" cellspacing="0" cellpadding="0" border="0" align="left">
                                <tbody><tr>
                                        <td style="padding:14px">Hello {subject_first_name},</td>

                                    </tr>
                                </tbody></table></td>
                    </tr>
                </tbody></table>

            <table border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF" style="max-width:600px;min-width:320px;border:1px solid #e2e2e2">
                <tbody><tr>
                        <td valign="top" width="600">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tbody><tr>

                                    </tr>
                                    <tr>

                                    <tr>

                                    </tr>
                                    <tr>

                                    </tr><tr>
                                        <td height="10"></td>
                                    </tr>
                                    <tr>
                                        <td><table width="90%" border="0" cellspacing="0" cellpadding="0">
                                                <tbody><tr>
                                                        <td width="10"></td>
                                                        <td style="font-family:calibri;font-size:15px;color:#1b1b1b;text-align:justify;line-height:20px">
                                                            {object_first_name} from "<b>{event_name}"</b>  just sent you a meeting request:
                                                            <br><br>Date of meeting: {meeting_date}
                                                            <br>Time: {meeting_time}
                                                            <br><br>Message from {object_first_name} : " {msg_content}"
                                                            <br><br><a href="'.SITE_URL.'events">Click here</a> to revert to the meeting request, as well as network with other attendees at this event.
                                                        </td>
                                                        <td width="10"></td>
                                                    </tr>
                                                </tbody></table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top">
                                            <div style="width:100%"></div></td>
                                    </tr>

                                    <tr>
                                        <td height="10"></td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#5c884d"></td>
                                    </tr>
                                    <tr>
                                        <td height="20"></td>
                                    </tr>';
    $html                       .= email_footer(); 
    $html                       .= '</tbody></table></td></tr></tbody></table></div></body></html>';
    return $html;
}

function reply_setup_meeting_email_temp()
{
    $html = '<html>
    <head><title>Procialize</title></head>
    <body>
        <div>
            <table cellspacing="0" cellpadding="0" border="0" bgcolor="#ebebeb" align="center" style="max-width:600px;min-width:200px">
                <tbody><tr>
                        <td width="600" style="padding:10px 0px">
                            <table width="217" cellspacing="0" cellpadding="0" border="0" align="left">
                                <tbody><tr>
                                        <td style="padding:14px">Hello {subject_first_name},</td>

                                    </tr>
                                </tbody></table></td>
                    </tr>
                </tbody></table>

            <table border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF" style="max-width:600px;min-width:320px;border:1px solid #e2e2e2">
                <tbody><tr>
                        <td valign="top" width="600">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tbody><tr>

                                    </tr>
                                    <tr>

                                    <tr>

                                    </tr>
                                    <tr>

                                    </tr><tr>
                                        <td height="10"></td>
                                    </tr>
                                    <tr>
                                        <td><table width="90%" border="0" cellspacing="0" cellpadding="0">
                                                <tbody><tr>
                                                        <td width="10"></td>
                                                        <td style="font-family:calibri;font-size:15px;color:#1b1b1b;text-align:justify;line-height:20px">
                                                            {object_first_name} from <b>"{event_name}"</b>  just {responce}ed your meeting request::
                                                            <br><br>Date of meeting: {meeting_date}
                                                            <br>Time:{meeting_time}
                                                            <br><br>Message from {object_first_name} : "{msg_content}"
                                                            <br><br><a href="'.SITE_URL.'events">Click here</a> to view more details, as well as network with other attendees at this event.
                                                        </td>
                                                        <td width="10"></td>
                                                    </tr>
                                                </tbody></table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top">
                                            <div style="width:100%"></div></td>
                                    </tr>

                                    <tr>
                                        <td height="10"></td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#5c884d"></td>
                                    </tr>
                                    <tr>
                                        <td height="20"></td>
                                    </tr>';
    $html                       .= email_footer(); 
    $html                       .= '</tbody></table></td></tr></tbody></table></div></body></html>';
    
    return $html;
}

function before_15_min_email_to_attendee()
{
    $html = '<html>
    <head><title>Procialize</title></head>
    <body>
        <div>
            <table cellspacing="0" cellpadding="0" border="0" bgcolor="#ebebeb" align="center" style="max-width:600px;min-width:200px">
                <tbody><tr>
                        <td width="600" style="padding:10px 0px">
                            <table width="217" cellspacing="0" cellpadding="0" border="0" align="left">
                                <tbody><tr>
                                        <td style="padding:14px">Hello {subject_first_name},</td>

                                    </tr>
                                </tbody></table></td>
                    </tr>
                </tbody></table>

            <table border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF" style="max-width:600px;min-width:320px;border:1px solid #e2e2e2">
                <tbody><tr>
                        <td valign="top" width="600">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tbody><tr>

                                    </tr>
                                    <tr>

                                    <tr>

                                    </tr>
                                    <tr>

                                    </tr><tr>
                                        <td height="10"></td>
                                    </tr>
                                    <tr>
                                        <td><table width="90%" border="0" cellspacing="0" cellpadding="0">
                                                <tbody><tr>
                                                        <td width="10"></td>
                                                        <td style="font-family:calibri;font-size:15px;color:#1b1b1b;text-align:justify;line-height:20px">
                                                            Your Session "<b>{session_name}</b>" from "<b>{event_name}</b>" is scheduled to start at {session_time}. 
                                                            <br><br>
                                                            Request you to assemble in "track name" before start of the session.

                                                        </td>
                                                        <td width="10"></td>
                                                    </tr>
                                                </tbody></table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top">
                                            <div style="width:100%"></div></td>
                                    </tr>

                                    <tr>
                                        <td height="10"></td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#5c884d"></td>
                                    </tr>
                                    <tr>
                                        <td height="20"></td>
                                    </tr>';
    $html                       .= email_footer(); 
    $html                       .= '</tbody></table></td></tr></tbody></table></div></body></html>';
    
    return $html;
}
function before_10_min_email_to_attendee()
{
    $html = '<html>
    <head><title>Procialize</title></head>
    <body>
        <div>
            <table cellspacing="0" cellpadding="0" border="0" bgcolor="#ebebeb" align="center" style="max-width:600px;min-width:200px">
                <tbody><tr>
                        <td width="600" style="padding:10px 0px">
                            <table width="217" cellspacing="0" cellpadding="0" border="0" align="left">
                                <tbody><tr>
                                        <td style="padding:14px">Hello {subject_first_name},</td>

                                    </tr>
                                </tbody></table></td>
                    </tr>
                </tbody></table>

            <table border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF" style="max-width:600px;min-width:320px;border:1px solid #e2e2e2">
                <tbody><tr>
                        <td valign="top" width="600">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tbody><tr>

                                    </tr>
                                    <tr>

                                    <tr>

                                    </tr>
                                    <tr>

                                    </tr><tr>
                                        <td height="10"></td>
                                    </tr>
                                    <tr>
                                        <td><table width="90%" border="0" cellspacing="0" cellpadding="0">
                                                <tbody><tr>
                                                        <td width="10"></td>
                                                        <td style="font-family:calibri;font-size:15px;color:#1b1b1b;text-align:justify;line-height:20px">
                                                            Hope you liked the Session "<b>{session_name}</b>" from "<b>{event_name}</b>" 
                                                            <br><br>
                                                            Kindly spare 2 minutes to give your valuable feedback for the session. 
                                                            You can provide your feedback by visiting the Session page and rate the Session between 1-5 (1 being worst and 5 being best).
                                                        </td>
                                                        <td width="10"></td>
                                                    </tr>
                                                </tbody></table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top">
                                            <div style="width:100%"></div></td>
                                    </tr>

                                    <tr>
                                        <td height="10"></td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#5c884d"></td>
                                    </tr>
                                    <tr>
                                        <td height="20"></td>
                                    </tr>';
    $html                       .= email_footer(); 
    $html                       .= '</tbody></table></td></tr></tbody></table></div></body></html>';
    
    return $html;
}


function saved_share_profile_temp()
{
    $html = '<html>
    <head><title>Procialize</title></head>
    <body>
        <div>
            <table cellspacing="0" cellpadding="0" border="0" bgcolor="#ebebeb" align="center" style="max-width:600px;min-width:200px">
                <tbody><tr>
                        <td width="600" style="padding:10px 0px">
                            <table width="217" cellspacing="0" cellpadding="0" border="0" align="left">
                                <tbody><tr>
                                        <td style="padding:14px">Hello {subject_first_name},</td>

                                    </tr>
                                </tbody></table></td>
                    </tr>
                </tbody></table>

            <table border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF" style="max-width:600px;min-width:320px;border:1px solid #e2e2e2">
                <tbody><tr>
                        <td valign="top" width="600">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tbody><tr>

                                    </tr>
                                    <tr>

                                    <tr>

                                    </tr>
                                    <tr>

                                    </tr><tr>
                                        <td height="10"></td>
                                    </tr>
                                    <tr>
                                        <td><table width="90%" border="0" cellspacing="0" cellpadding="0">
                                                <tbody><tr>
                                                        <td width="10"></td>
                                                        <td style="font-family:calibri;font-size:15px;color:#1b1b1b;text-align:justify;line-height:20px">
                                                            {object_first_name} from <b>"{event_name}"</b> just {save_shared} your profile.
                                                            <br><br><a href="'.SITE_URL.'events">Click here</a> to interact with this user, as well as network with other attendees at this event.
                                                        </td>
                                                        <td width="10"></td>
                                                    </tr>
                                                </tbody></table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top">
                                            <div style="width:100%"></div></td>
                                    </tr>

                                    <tr>
                                        <td height="10"></td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#5c884d"></td>
                                    </tr>
                                    <tr>
                                        <td height="20"></td>
                                    </tr>';
    $html                       .= email_footer(); 
    $html                       .= '</tbody></table></td></tr></tbody></table></div></body></html>';
    return $html;
}

function email_footer()
{
    $html       = '<tr>
                                        <td bgcolor="#ebebeb"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tbody><tr>
                                                        <td width="10"></td>
                                                        <td height="10"></td>
                                                        <td width="10"></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td style="font-family:calibri;font-size:14px;color:#1b1b1b;text-align:center">Log on to the event at <a href="'.SITE_URL.'events">procialize.in</a></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td height="10"></td>
                                                        <td></td>
                                                    </tr>
                                                </tbody></table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#ebebeb"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tbody><tr>
                                                        <td width="10"></td>
                                                        <td height="10"></td>
                                                        <td width="10"></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td style="font-family:calibri;font-size:14px;color:#1b1b1b;text-align:center">
                                                            You can change your email notification settings by clicking <a href="'.SITE_URL.'events">here</a>.
                                                            <br>Feel free to write to us @ admin@procialize.in for any queries.
                                                            <br>Team Procialize</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td height="10"></td>
                                                        <td></td>
                                                    </tr>
                                                </tbody></table>
                                        </td>
                                    </tr>';
    return $html;
}

