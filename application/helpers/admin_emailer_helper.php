<?php

function passcode_to_attendee_speaker($title = '')
{
    $html           = '<html><head><title>Procialize</title></head><body><div>';
    $html           .= email_header();

    $html           .='<table border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF" style="max-width:600px;min-width:320px;border:1px solid #e2e2e2">
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
                                                            Welcome to Procialize - The official networking app for {event_name}
                                                            <br><br><b>Log on to the event at <a href="'.SITE_URL.'events">procialize.in</a> by using passcode {passcode} (not case sensitive)</b>
                                                            <br><br>With this mobile website, you can 
                                                            <br>1.View attendee profiles by name, designation, company name, industry, functionality etc. You can then send messages and set up meetings
                                                            <br>2.View Speaker profiles, post questions and provide session wise feedback
                                                            <br>3.Download brochures, fill surveys and network!

                                                            <br><br>Here are details of the Event for which you have subscribed: 
                                                            <br><br>Event Name: {event_name}
                                                            <br><br>Duration: {duration} 
                                                            <br><br>Event Venue Address: {address}
                                                            <br><br>You can login to the App using your email address and password {password}
                                                            <br><br>So go ahead and log in, networking awaits you!
                                                            <br>In case you face any difficulties, you may call Abhay Bhatia on 98203 25285 or email him at abhay@procialize.in

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

function alert_from_organizer()
{
    $html           = '<html><head><title>Procialize</title></head><body><div>';
    $html           .= email_header();

    $html           .='<table border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF" style="max-width:600px;min-width:320px;border:1px solid #e2e2e2">
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
                                                            The Organizer of this event has just sent an alert message:
                                                            <br><br><b>"{message_content}"</b>
                                                            <br><br>In case you face any difficulties, you may call Abhay Bhatia on 98203 25285 or email him at abhay@procialize.in

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
function notification_from_organizer()
{
    $html           = '<html><head><title>Procialize</title></head><body><div>';
    $html           .= email_header();

    $html           .='<table border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF" style="max-width:600px;min-width:320px;border:1px solid #e2e2e2">
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
                                                            The Organizer of this event has just sent a notification message:
                                                            <br><br><b>"{message_content}"</b>
                                                            <br><br>In case you face any difficulties, you may call Abhay Bhatia on 98203 25285 or email him at abhay@procialize.in

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
function feedback_requested_by_organizer()
{
    $html           = '<html><head><title>Procialize</title></head><body><div>';
    $html           .= email_header();

    $html           .='<table border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF" style="max-width:600px;min-width:320px;border:1px solid #e2e2e2">
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
                                                            The Organizer of this event has just sent a feedback request:
                                                            <br><br><b>"{message_content}"</b>
                                                            <br><br>In case you face any difficulties, you may call Abhay Bhatia on 98203 25285 or email him at abhay@procialize.in

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

function email_header()
{
    $html       = '<table cellspacing="0" cellpadding="0" border="0" bgcolor="#ebebeb" align="center" style="max-width:600px;min-width:200px">
                <tbody><tr>
                        <td width="600" style="padding:10px 0px">
                            <table width="217" cellspacing="0" cellpadding="0" border="0" align="left">
                                <tbody>
                                    <tr>
                                        <td style="padding:14px;ont-family:calibri;font-size:14px;color:#1b1b1b;">
                                            Hello {first_name},
                                        </td>
                                    </tr>
                                </tbody></table></td>
                    </tr>
                </tbody></table>';
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