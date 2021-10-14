@extends('layouts.email_consumer')


@section('content')
    <!-- Start of Main Content -->
    <tr>
        <td bgcolor="#FFFFFF" align="center" style="">
            <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" class="devicewidth" style="">
                <tbody style="">
                    <!-- Start Spacer -->
                    <tr>
                        <td class="w30" width="70" style="font-size:1px; line-height:1px;">&nbsp;</td>
                        <td height="22" style="font-size:1px; line-height:1px;">&nbsp;</td>
                        <td class="w30" width="70" style="font-size:1px; line-height:1px;">&nbsp;</td>
                    </tr>
                    <!-- End Spacer -->


                    <tr >
                        <td class="w30" width="70" style="font-size:1px; line-height:1px;">&nbsp;</td>
                        <td align="center" class="mktEditable" id="headline_image" style="font-size:1px; line-height:1px; ">
                            <div>
                                <hr style="width: 50%;opacity: 0.2;">
                            </div>
                        </td>
                        <td class="w30" width="70" style="font-size:1px; line-height:1px;">&nbsp;</td>
                    </tr>

                    <!-- Start Spacer -->
                    <tr>
                        <td class="w22" width="70" style="font-size:1px; line-height:1px;">&nbsp;</td>
                        <td height="30" style="font-size:1px; line-height:1px;">&nbsp;</td>
                        <td class="w22" width="70" style="font-size:1px; line-height:1px;">&nbsp;</td>
                    </tr>
                    <!-- Start Spacer -->
                    <tr>
                        <td class="w30" width="70" style="font-size:1px; line-height:1px;">&nbsp;</td>
                        <td height="22" style="font-size:1px; line-height:1px;">&nbsp;</td>
                        <td class="w30" width="70" style="font-size:1px; line-height:1px;">&nbsp;</td>
                    </tr>
                    <!-- End Spacer --><!-- Start Spacer -->
                    <tr>
                        <td class="w30" width="70" style="font-size:1px; line-height:1px;">&nbsp;</td>
                        <td height="22" style="font-size:1px; line-height:1px;">&nbsp;</td>
                        <td class="w30" width="70" style="font-size:1px; line-height:1px;">&nbsp;</td>
                    </tr>
                    <!-- End Spacer -->
                    <!-- End Spacer -->
                    <tr>
                        <td class="w30" width="70" style="font-size:1px; line-height:1px;">&nbsp;</td>
                        <td class="mktEditable headline mktEditable headline" style="font-family:'Lato', sans-serif;font-size:12px;color: #000000;text-align: left;line-height:14px;font-weight: normal;text-transform:none;">
                            <span style="color: #000000;font-family: 'Lato', sans-serif;font-size: 14px;font-style: normal;font-variant-ligatures: normal;font-variant-caps: normal;font-weight: 900;letter-spacing: normal;orphans: 2;text-align: left;text-indent: 0px;text-transform: uppercase;white-space: normal;widows: 2;word-spacing: 0px;-webkit-text-stroke-width: 0px;background-color: #ffffff;display: inline !important;float: left;">
                                réinitialiser votre mot de passe
                            </span>
                        </td>
                        <td class="w30" width="70" style="font-size:1px; line-height:1px;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td class="w22" width="70" style="font-size:1px; line-height:1px;">&nbsp;</td>
                        <td height="22" style="font-size:1px; line-height:1px;">&nbsp;</td>
                        <td class="w22" width="70" style="font-size:1px; line-height:1px;">&nbsp;</td>
                    </tr>
                    <!-- Start Spacer -->
                    <tr>
                        <td class="w30" width="70" style="font-size:1px; line-height:1px;">&nbsp;</td>
                        <td height="22" style="font-size:1px; line-height:1px;">&nbsp;</td>
                        <td class="w30" width="70" style="font-size:1px; line-height:1px;">&nbsp;</td>
                    </tr>
                    <!-- End Spacer --><!-- Start Spacer -->
                    <tr>
                        <td class="w30" width="70" style="font-size:1px; line-height:1px;">&nbsp;</td>
                        <td height="22" style="font-size:1px; line-height:1px;">&nbsp;</td>
                        <td class="w30" width="70" style="font-size:1px; line-height:1px;">&nbsp;</td>
                    </tr>
                    <!-- End Spacer -->

                    <tr style="">
                        <td class="w30" width="70" style="font-size:1px; line-height:1px;">&nbsp;</td>
                        <td class="mktEditable content mktEditable content" style="font-family:'Lato', sans-serif;font-size:16px;color:#1d1c1c;text-align:center;line-height: 20px;font-weight:normal;text-transform:none;padding: 0px 36px;">
                            <p style="line-height: 20px;">
                                <span style="color: #1d1c1c;font-family: 'Lato', sans-serif;font-size: 14px;font-style: normal;font-variant-ligatures: normal;font-variant-caps: normal;font-weight: normal;letter-spacing: normal;orphans: 2;text-align: center;text-indent: 0px;text-transform: none;white-space: normal;widows: 2;word-spacing: 0px;-webkit-text-stroke-width: 0px;background-color: #ffffff;display: inline !important;float: none;line-height: 20px;">
                                    <span style="color: #1d1c1c;font-family: 'Lato', sans-serif;font-size: 14px;font-style: normal;font-variant-ligatures: normal;font-variant-caps: normal;font-weight: 400;letter-spacing: normal;orphans: 2;text-align: center;text-indent: 0px;text-transform: none;white-space: normal;widows: 2;word-spacing: 0px;-webkit-text-stroke-width: 0px;background-color: #ffffff;text-decoration-style: initial;text-decoration-color: initial;display: inline !important;float: none;line-height: 20px;">

                                        <a href="{{env('USER_URL').'/reset-password/'.$token }}" class="btn-email"
                                            style="font-family: 'Lato', sans-serif;
                                            font-size: 12px !important;
                                            border-radius: 10px;
                                            color: white;
                                            background-color: #007dba;
                                            display: block;
                                            font-weight: bold;
                                            text-decoration: none;
                                            text-align: center!important;
                                            padding: 10px 3px;" target="_blank">
                                            change mot de passe
                                        </a>
                                    </span>
                                </span>
                            </p>
                        </td>
                        <td class="w30" width="70" style="font-size:1px; line-height:1px;">&nbsp;</td>
                    </tr>
                    <!-- Start Spacer -->
                    <tr>
                        <td class="w30" width="70" style="font-size:1px; line-height:1px;">&nbsp;</td>
                        <td height="22" style="font-size:1px; line-height:1px;">&nbsp;</td>
                        <td class="w30" width="70" style="font-size:1px; line-height:1px;">&nbsp;</td>
                    </tr>
                    <!-- End Spacer --><!-- Start Spacer -->
                    <tr>
                        <td class="w30" width="70" style="font-size:1px; line-height:1px;">&nbsp;</td>
                        <td height="22" style="font-size:1px; line-height:1px;">&nbsp;</td>
                        <td class="w30" width="70" style="font-size:1px; line-height:1px;">&nbsp;</td>
                    </tr>
                    <!-- End Spacer -->
                </tbody>
            </table>
        </td>
    </tr>
    <!-- End of Main Content -->
@endsection

