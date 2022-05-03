<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://opengraphprotocol.org/schema/">
    <head>
        <title>Facebook Login Button PHP class</title>
        <meta name="description" content="PHP Example of creting Facebook Login Button using the Graph API." />
        <link rel="stylesheet" type="text/css" href="styles.css" />
        <?php include 'HeaderScripts.php'; ?>
    </head>
    <body>
        <?php
            require_once 'facebook.php';
            require_once 'faceconn/faceconn.php';
            UseGraphAPI();
        ?>

        <table>
            <tr>
                <td style="width:20%"></td>
                <td>
                    <table width="840px">
                        <tr>
                            <td>
                                <a href="http://faceconn.com/demo/"><img src="images/banner.png" alt="Facebook PHP Demo" /></a>
                            </td>
                        </tr>
                    </table>

                    <table>
                        <tr>

                            <td valign="top" style="width:770px">
                                <div style="padding:5px; padding-top:3px">
                                    <!-- CONTENT DIV -->
                                    <form id="form1" action="UserDataPage.php">
                                        <div class="contentdiv">

                                            <p style="text-align: justify">
                                        
                                            <b>Example:</b><br />


                                            <?php
                                                // creating new instance of Login Button
                                                $login = new LoginButton();

                                                // Optional: setting text and size
                                                $login->SetText("Sign up with Facebook");
                                                $login->SetSize("large");

                                                // Optional: setting list of extended permissions
                                                $login->SetPermissions("email, publish_stream");

                                                // Optional: setting the form id which will be submitted
                                                // on successfull login (redirect on User Data page)
                                                $login->SetOnLoginSubmitForm("form1");

                                                // Render commmand on the page
                                                $login->Render();
                                            ?>
                                            <br /><br />
                                        </div>
                                    </form> 
                                    <br />
                                    <?php include 'SessionCheck.php'; ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="width:20%"></td>
            </tr>
        </table>
    </body>
</html>




