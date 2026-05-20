<?php
header("Content-Type:text/css");
$color       = "#f0f"; // Change your Color Here
$secondColor = "#ff8"; // Change your Color Here

function checkhexcolor($color)
{
    return preg_match('/^#[a-f0-9]{6}$/i', $color);
}
$color = '';
$secondColor = '';
if (isset($_GET['color']) and $_GET['color'] != '') {
    $color = "#" . $_GET['color'];
}

if (!$color or !checkhexcolor($color)) {
    $color = "#336699";
}

function checkhexcolor2($secondColor)
{
    return preg_match('/^#[a-f0-9]{6}$/i', $secondColor);
}

if (isset($_GET['secondColor']) and $_GET['secondColor'] != '') {
    $secondColor = "#" . $_GET['secondColor'];
}

if (!$secondColor or !checkhexcolor2($secondColor)) {
    $secondColor = "#336699";
}
?>

.header-bottom-area .navbar-collapse .main-menu li a.active {
color: <?php echo $color ?>;
}
.header-bottom-area .navbar-collapse .main-menu li a:hover {
color: <?php echo $color ?>;
}

#overlayer {
background: <?php echo $color ?>;
}

.header-bottom-area .navbar-collapse .main-menu li .sub-menu li::before {
background-color: <?php echo $color ?>;
}
.submit-btn{
background-color:<?php echo $color ?>;
color:#fff;
}

.select2-container--open .select2-selection.select2-selection--single,
.select2-container--open .select2-selection.select2-selection--multiple {
border-color: <?php echo $color ?> !important;
}

.select2-container--focus .select2-selection.select2-selection--single,
.select2-container--focus .select2-selection.select2-selection--multiple {
border-color: <?php echo $color ?> !important;
}

textarea:focus{
border: .3px solid <?php echo $color ?> !important;
}

.cookies-card__icon{
background-color:<?php echo $color ?>
}
.cmn-btn {
background: <?php echo $color ?>;
box-shadow: 0px 10px 16px 0px <?php echo $color ?>33;
}
.cmn-btn:focus, .cmn-btn:hover {
color: white;
box-shadow: 0px 10px 26px 0px <?php echo $color ?>80;
}

.scrollToTop {
background-color: <?php echo $color ?>;
}
.scrollToTop:hover {
box-shadow: 0px 10px 26px 0px <?php echo $color ?>80;
}

*::-webkit-scrollbar-button {
background-color: <?php echo $color ?>;
}
*::-webkit-scrollbar-thumb {
background-color: <?php echo $color ?>;
}
::selection {
background-color: <?php echo $color ?>;
}

.feature-section .feature-item .feature-icon i {
color: <?php echo $color ?>;
background-color: <?php echo $color ?>1a;
}

.about-section .about-content .title-border::before, .contact-info-item {
border: 1px solid <?php echo $color ?>;
}

.about-section .about-content .title-border::after {
background-color: <?php echo $color ?>;
}

.counter-section .counter-item .counter-icon {
background-color: <?php echo $color ?>1a;
color: <?php echo $color ?>;
}

.cmn-btn-active {
color: <?php echo $color ?>;
box-shadow: 0px 10px 16px 0px <?php echo $color ?>33;
}

.section-header .sub-title {
color: <?php echo $color ?>;
background-color: <?php echo $color ?>1a;
}
.section-header .title-border::before {
border: 1px solid <?php echo $color ?>;
}
.section-header .title-border::after {
background-color: <?php echo $color ?>;
}
.service-section .service-item .service-icon i {
color: <?php echo $color ?>;
background-color: <?php echo $color ?>1a;
}
.service-section .service-item:hover {
background-color: <?php echo $color ?>;
}

.faq-wrapper .faq-item.open .faq-title {
background: <?php echo $color ?>;
}

.custom-btn {
color: <?php echo $color ?>;
}
.custom-btn:hover {
color: <?php echo $color ?>;
}

.call-to-action-section .call-to-action-content .call-to-action-form .submit-btn {
background-color: <?php echo $color ?>;
border: 1px solid <?php echo $color ?>;
}

.footer-social li a:hover, .footer-social li a.active {
background-color: <?php echo $color ?>;
opacity:0.5;
}

.register-section .register-form-area .register-form .submit-btn {
background-color: <?php echo $color ?>;
}
.contact-info-item i {
color: <?php echo $color ?>;
background-color: <?php echo $color ?>1a;
}

.contact-info-item.active {
background-color: <?php echo $color ?>;
}

.breadcrumb li {
color: <?php echo $color ?>;
}
.breadcrumb-item.active::before {
color: <?php echo $color ?>;
}

.change-catagory-area {
background-color: <?php echo $color ?>;
}

.cmn-btn-active:focus, .cmn-btn-active:hover {
color:<?php echo $color ?>;
box-shadow: 0px 10px 26px 0px <?php echo $color ?>80;
}

.navbar-toggler span {
color: <?php echo $color ?>;
}

.nice-select .option:hover {
background-color: <?php echo $color ?>;
}

.footer-section {
background-color: <?php echo $secondColor ?>;
}
.link-text{
color:<?php echo $color ?>;
}

.btn--base{
background-color: <?php echo $color ?> !important;
}

.btn--base:hover,
.btn--base:focus,
.btn--base:active {
background-color: <?php echo $color ?> !important;
}


.privacy-area{
background-color: <?php echo $secondColor ?>;
}

.text--base{
color:<?php echo $color ?> !important;
}

.nice-select:active,
.nice-select.open,
.nice-select:focus {
border-color: <?php echo $color ?> !important;
}

.footer-social li a {
background-color:<?php echo $color ?>;
}
.dashboard .sidebar-submenu-list__item.active>a::before,.dashboard .sidebar-submenu-list__link:hover::before{
border-color:<?php echo $color ?> !important;
}
.dashboard .sidebar-menu-list__item.has-dropdown>a.side-menu--open, .dashboard .sidebar-submenu-list__item.active>a,.dashboard .sidebar-submenu-list__item.active>a::before,.dashboard .sidebar-menu-list__item.has-dropdown>a.side-menu--open:after,.dashboardm.dashboard .sidebar-menu-list__item.has-dropdown:hover>a::after,.dashboard .sidebar-menu-list__item.has-dropdown:hover>a::after,.dashboard .sidebar-submenu-list__link:hover{
color:<?php echo $color ?> !important;
}
.dashboard .sidebar-menu-list__link::before,.sidebar_menu_btn{
background:<?php echo $color ?> !important;
}
.dashboard .sidebar-menu-list__link:hover,.dashboard .sidebar-menu-list__item.active>a{
background-color:<?php echo $color ?>0f !important;
color:<?php echo $color ?> !important;
}
.payment-item:has(.payment-item__radio:checked){
border-left:3px solid <?php echo $color ?> !important;
}
.payment-item:has(.payment-item__radio:checked) .payment-item__check{
border:3px solid <?php echo $color ?> !important;
}
.payment-item__check{
border:1px solid <?php echo $color ?> !important;
}

.select2-container--default .select2-search--dropdown .select2-search__field:focus{
    border-color : <?php echo $color ?> !important;
}

.form-check-input:checked{
    background-color: <?php echo $color ?> !important;
    border-color: <?php echo $color ?> !important;
}

.form-check-input:focus{
    border-color: <?php echo $color ?> !important;
}

.form--check .form-check-input:checked{
    background-color: <?php echo $color ?> !important;
    border-color: <?php echo $color ?> !important;
}

<!-- base color - dd6c00 -->
<!-- secondary color - e19f00 -->
