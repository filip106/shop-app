<?php

$siteTitle = 'Login';

include "base-header.php";

?>

    <div class="breadcrumb-area pt-205 pb-210" style="background-image: url(img/bg/breadcrumb.jpg)">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <h2>login</h2>
                <ul>
                    <li><a href="#">home</a></li>
                    <li> login </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- login-area start -->
    <div class="register-area ptb-100">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-12 col-lg-6 col-xl-6 ml-auto mr-auto">
                    <div class="login">
                        <div class="login-form-container">
                            <div class="login-form">
                                <form action="#" method="post">
                                    <input type="text" name="user-name" placeholder="Username">
                                    <input type="password" name="user-password" placeholder="Password">
                                    <div class="button-box">
                                        <div class="login-toggle-btn">
                                            <input type="checkbox">
                                            <label>Remember me</label>
                                            <a href="#">Forgot Password?</a>
                                        </div>
                                        <button type="submit" class="default-btn floatright">Login</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- login-area end -->
    <!-- modal -->
    <div class="modal fade" id="exampleCompare" tabindex="-1" role="dialog" aria-hidden="true">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span class="pe-7s-close" aria-hidden="true"></span>
        </button>
        <div class="modal-dialog modal-compare-width" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="#">
                        <div class="table-content compare-style table-responsive">
                            <table>
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>
                                        <a href="#">Remove <span>x</span></a>
                                        <img src="img/cart/4.jpg" alt="">
                                        <p>Blush Sequin Top </p>
                                        <span>$75.99</span>
                                        <a class="compare-btn" href="#">Add to cart</a>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="compare-title"><h4>Description </h4></td>
                                    <td class="compare-dec compare-common">
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has beenin the stand ard dummy text ever since the 1500s, when an unknown printer took a galley</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="compare-title"><h4>Sku </h4></td>
                                    <td class="product-none compare-common">
                                        <p>-</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="compare-title"><h4>Availability  </h4></td>
                                    <td class="compare-stock compare-common">
                                        <p>In stock</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="compare-title"><h4>Weight   </h4></td>
                                    <td class="compare-none compare-common">
                                        <p>-</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="compare-title"><h4>Dimensions   </h4></td>
                                    <td class="compare-stock compare-common">
                                        <p>N/A</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="compare-title"><h4>brand   </h4></td>
                                    <td class="compare-brand compare-common">
                                        <p>HasTech</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="compare-title"><h4>color   </h4></td>
                                    <td class="compare-color compare-common">
                                        <p>Grey, Light Yellow, Green, Blue, Purple, Black </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="compare-title"><h4>size    </h4></td>
                                    <td class="compare-size compare-common">
                                        <p>XS, S, M, L, XL, XXL </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="compare-title"></td>
                                    <td class="compare-price compare-common">
                                        <p>$75.99 </p>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php
include "base-footer.php";