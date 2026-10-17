<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EduminAdminController extends Controller
{
	public $page_description;
	
    // Dashboard
    public function dashboard(){
        $page_title = 'Dashboard';
        $page_description = $this->page_description();
        return view('edumin.dashboard.index', compact('page_title', 'page_description'));
    }
	
	// Dashboard 2
	public function dashboard_2(){
        $page_title = 'Dashboard';
        $page_description = $this->page_description();
        return view('edumin.dashboard.index_2', compact('page_title', 'page_description'));
    }
	// Dashboard 3
	public function dashboard_3(){
        $page_title = 'Dashboard';
        $page_description = $this->page_description();
        return view('edumin.dashboard.index_3', compact('page_title', 'page_description'));
    }

    // Dashboard 3
	public function index_3(){
        $page_title = 'Dashboard';
        $page_description = $this->page_description();
        return view('edumin.dashboard.index_3', compact('page_title', 'page_description'));
    }
    // Dashboard 3
	public function about_courses(){
        $page_title = 'Dashboard';
        $page_description = $this->page_description();
        return view('edumin.dashboard.about_courses', compact('page_title', 'page_description'));
    }

    // Dashboard 3
	public function about_student(){
        $page_title = 'Dashboard';
        $page_description = $this->page_description();
        return view('edumin.dashboard.about_student', compact('page_title', 'page_description'));
    }
	
	// add_courses
	
	public function add_courses(){
        $page_title = 'Search Jobs';
        $page_description = $this->page_description();
        return view('edumin.dashboard.add_courses', compact('page_title', 'page_description'));
    }
	
	// add_departments
	
	public function add_departments(){
        $page_title = 'Applications';
        $page_description = $this->page_description();
        return view('edumin.dashboard.add_departments', compact('page_title', 'page_description'));
    }
    
	// professor_profile
	
	public function professor_profile(){
        $page_title = 'Applications';
        $page_description = $this->page_description();
        return view('edumin.dashboard.professor_profile', compact('page_title', 'page_description'));
    }

	// add_fees
	
	public function add_fees(){
        $page_title = 'My Profile';
        $page_description = $this->page_description();
        return view('edumin.dashboard.add_fees', compact('page_title', 'page_description'));
    }

    // add_holiday
	public function add_holiday(){
        $page_title = 'Job List';
        $page_description = $this->page_description();
        return view('edumin.dashboard.add_holiday', compact('page_title', 'page_description'));
    }

    // add_library
	public function add_library(){
        $page_title = 'Job View';
        $page_description = $this->page_description();
        return view('edumin.dashboard.add_library', compact('page_title', 'page_description'));
    }

    //add_professor
	public function add_professor(){
        $page_title = 'New Job';
        $page_description = $this->page_description();
        return view('edumin.dashboard.add_professor', compact('page_title', 'page_description'));
    }

    // add_staff 
	public function add_staff (){
        $page_title = 'Statistics';
        $page_description = $this->page_description();
        return view('edumin.dashboard.add_staff ', compact('page_title', 'page_description'));
    }

    // add_student 
	public function add_student(){
        $page_title = 'Companies';
        $page_description = $this->page_description();
        return view('edumin.dashboard.add_student ', compact('page_title', 'page_description'));
    }

    // all_courses 
	public function all_courses(){
        $page_title = 'Job Application';
        $page_description = $this->page_description();
        return view('edumin.dashboard.all_courses', compact('page_title', 'page_description'));
    }

    // all_departments 
	public function all_departments(){
        $page_title = 'Apply Job';
        $page_description = $this->page_description();
        return view('edumin.dashboard.all_departments', compact('page_title', 'page_description'));
    }

    // all_holiday 
	public function all_holiday(){
        $page_title = 'User Profile';
        $page_description = $this->page_description();
        return view('edumin.dashboard.all_holiday', compact('page_title', 'page_description'));
    }

    // all_library 
	public function all_library(){
        $page_title = 'User Profile';
        $page_description = $this->page_description();
        return view('edumin.dashboard.all_library', compact('page_title', 'page_description'));
    }

    // all_professors
	public function all_professors(){
        $page_title = 'User Profile';
        $page_description = $this->page_description();
        return view('edumin.dashboard.all_professors', compact('page_title', 'page_description'));
    }

     // all_staff
	public function all_staff(){
        $page_title = 'User Profile';
        $page_description = $this->page_description();
        return view('edumin.dashboard.all_staff', compact('page_title', 'page_description'));
    }
    // all_students

	public function all_students(){
        $page_title = 'User Profile';
        $page_description = $this->page_description();
        return view('edumin.dashboard.all_students', compact('page_title', 'page_description'));
    }

    // edit_courses

	public function edit_courses(){
        $page_title = 'User Profile';
        $page_description = $this->page_description();
        return view('edumin.dashboard.edit_courses', compact('page_title', 'page_description'));
    }

    // edit_departments

	public function edit_departments(){
        $page_title = 'User Profile';
        $page_description = $this->page_description();
        return view('edumin.dashboard.edit_departments', compact('page_title', 'page_description'));
    }

    // edit_holiday

	public function edit_holiday(){
        $page_title = 'User Profile';
        $page_description = $this->page_description();
        return view('edumin.dashboard.edit_holiday', compact('page_title', 'page_description'));
    }

    // edit_library

	public function edit_library(){
        $page_title = 'User Profile';
        $page_description = $this->page_description();
        return view('edumin.dashboard.edit_library', compact('page_title', 'page_description'));
    }

    // edit_professor

	public function edit_professor(){
        $page_title = 'User Profile';
        $page_description = $this->page_description();
        return view('edumin.dashboard.edit_professor', compact('page_title', 'page_description'));
    }

    // edit_staff

	public function edit_staff(){
        $page_title = 'User Profile';
        $page_description = $this->page_description();
        return view('edumin.dashboard.edit_staff', compact('page_title', 'page_description'));
    }

     // edit_student

    public function edit_student(){
        $page_title = 'User Profile';
        $page_description = $this->page_description();
        return view('edumin.dashboard.edit_student', compact('page_title', 'page_description'));
    }

    // event_management

    public function event_management(){
        $page_title = 'User Profile';
        $page_description = $this->page_description();
        return view('edumin.dashboard.event_management', compact('page_title', 'page_description'));
    }

    // fees_collection

    public function fees_collection(){
        $page_title = 'User Profile';
        $page_description = $this->page_description();
        return view('edumin.dashboard.fees_collection', compact('page_title', 'page_description'));
    }

    // fees_receipt

    public function fees_receipt(){
        $page_title = 'User Profile';
        $page_description = $this->page_description();
        return view('edumin.dashboard.fees_receipt', compact('page_title', 'page_description'));
    }

    // holiday_calendar 

    public function holiday_calendar(){
        $page_title = 'User Profile';
        $page_description = $this->page_description();
        return view('edumin.dashboard.holiday_calendar', compact('page_title', 'page_description'));
    }

    // staff_profile 

    public function staff_profile(){
        $page_title = 'User Profile';
        $page_description = $this->page_description();
        return view('edumin.dashboard.staff_profile', compact('page_title', 'page_description'));
    }
	
	// celandar 
	
	public function celandar(){
        $page_title = 'Celandar';
        $page_description = $this->page_description();
        return view('edumin.dashboard.celandar', compact('page_title', 'page_description'));
    }

    public function chat(){
        $page_title = 'Chat';
        $page_description = $this->page_description();
        return view('edumin.dashboard.chat', compact('page_title', 'page_description'));
    }
	
	// Reviews 
	
	public function activity(){
        $page_title = 'Activity';
        $page_description = $this->page_description();
        return view('edumin.dashboard.activity', compact('page_title', 'page_description'));
    }
	// app-calender 
	
	public function app_calender(){
        $page_title = 'Calender';
        $page_description = $this->page_description();
        return view('edumin.app.calender', compact('page_title', 'page_description'));
    }
	
	// app-profile-1
	
	public function app_profile(){
        $page_title = 'App Profile';
        $page_description = $this->page_description();
        return view('edumin.app.profile', compact('page_title', 'page_description'));
    }
	public function edit_profile(){
        $page_title = 'Edit Profile';
        $page_description = $this->page_description();
        return view('edumin.app.edit_profile', compact('page_title', 'page_description'));
    }
	
	// blog
	
	public function blog(){
        $page_title = 'Blog';
        $page_description = $this->page_description();
        return view('edumin.cms.blog', compact('page_title', 'page_description'));
    }
	
	// add catagery
	
	public function blog_category(){
        $page_title = 'Blog Category';
        $page_description = $this->page_description();
        return view('edumin.cms.blog_category', compact('page_title', 'page_description'));
    }
	
	// chart-chartist
	
	public function chart_chartist(){
        $page_title = 'Chart Chartlist';
        $page_description = $this->page_description();
        return view('edumin.chart.chartist', compact('page_title', 'page_description'));
    }
	
	// chart-chartjs
	
	public function chart_chartjs(){
        $page_title = 'Chart Chartjs';
        $page_description = $this->page_description();
        return view('edumin.chart.chartjs', compact('page_title', 'page_description'));
    }
	
	// chart-flot
	
	public function chart_flot(){
        $page_title = 'Chart Flot';
        $page_description = $this->page_description();
        return view('edumin.chart.flot', compact('page_title', 'page_description'));
    }
	
	// chart-morris
	
	public function chart_morris(){
        $page_title = 'Chart Morris';
        $page_description = $this->page_description();
        return view('edumin.chart.morris', compact('page_title', 'page_description'));
    }
	
	// chart-sparkline
	
	public function chart_sparkline(){
        $page_title = 'Chart Sparkline';
        $page_description = $this->page_description();
        return view('edumin.chart.sparkline', compact('page_title', 'page_description'));
    }
	
	
	// chart-peity
	
	public function chart_peity(){
        $page_title = 'Chart Peity';
        $page_description = $this->page_description();
        return view('edumin.chart.peity', compact('page_title', 'page_description'));
    }
	
	// Contant
	
	public function content(){
        $page_title = 'Content';
        $page_description = $this->page_description();
        return view('edumin.cms.content', compact('page_title', 'page_description'));
    }
	
	// Add content
	
	public function content_add(){
        $page_title = 'Add Content';
        $page_description = $this->page_description();
        return view('edumin.cms.content_add', compact('page_title', 'page_description'));
    }

	// add_email
	
	public function add_email(){
        $page_title = 'Add Email';
        $page_description = $this->page_description();
        return view('edumin.cms.add_email', compact('page_title', 'page_description'));
    }
	// add_email
	
	public function add_blog(){
        $page_title = 'Add Blog';
        $page_description = $this->page_description();
        return view('edumin.cms.add_blog ', compact('page_title', 'page_description'));
    }
	
	// ecom-checkout
	
	public function ecom_checkout(){
        $page_title = 'Ecom Checkout';
        $page_description = $this->page_description();
        return view('edumin.ecom.checkout', compact('page_title', 'page_description'));
    }
	
	// ecom-customers
	
	public function ecom_customers(){
        $page_title = 'Customers';
        $page_description = $this->page_description();
        return view('edumin.ecom.customers', compact('page_title', 'page_description'));
    }
	
	// ecom-invoice
	
	public function ecom_invoice(){
        $page_title = 'Invoice';
        $page_description = $this->page_description();
        return view('edumin.ecom.invoice', compact('page_title', 'page_description'));
    }
	
	// ecom-product-detail
	
	public function ecom_product_detail(){
        $page_title = 'Product Detai';
        $page_description = $this->page_description();
        return view('edumin.ecom.product_detail', compact('page_title', 'page_description'));
    }
	
	// ecom-product-grid
	
	public function ecom_product_grid(){
        $page_title = 'Product Grid';
        $page_description = $this->page_description();
        return view('edumin.ecom.product_grid', compact('page_title', 'page_description'));
    }
	
	// ecom-product-list
	
	public function ecom_product_list(){
        $page_title = 'Product List';
        $page_description = $this->page_description();
        return view('edumin.ecom.product_list', compact('page_title', 'page_description'));
    }
	
	// ecom-product-order
	
	public function ecom_product_order(){
        $page_title = 'Product Order';
        $page_description = $this->page_description();
        return view('edumin.ecom.product_order', compact('page_title', 'page_description'));
    }

	
	// email-compose
	
	public function email_compose(){
        $page_title = 'Email Compose';
        $page_description = $this->page_description();
        return view('edumin.message.compose', compact('page_title', 'page_description'));
    }
	
	//email-inbox
	
	public function email_inbox(){
        $page_title = 'Email Inbox';
        $page_description = $this->page_description();
        return view('edumin.message.inbox', compact('page_title', 'page_description'));
    }
	
	//email-read
	
	public function email_read(){
        $page_title = 'Email Read';
        $page_description = $this->page_description();
        return view('edumin.message.read', compact('page_title', 'page_description'));
    }
	
	//email-template
	
	public function email_template(){
        $page_title = 'Email Template';
        $page_description = $this->page_description();
        return view('edumin.cms.email_template', compact('page_title', 'page_description'));
    }
	
	//empty-page
	
	public function empty_page(){
        $page_title = 'Empty Page';
        $page_description = $this->page_description();
        return view('edumin.page.empty_page', compact('page_title', 'page_description'));
    }
	
	//Flat icon
	
	public function flat_icons(){
        $page_title = 'Flaticon Icons';
        $page_description = $this->page_description();
        return view('edumin.icon.flat_icons', compact('page_title', 'page_description'));
    }

    //feather icon
    public function feather(){
        $page_title = 'Feather Icons';
        $page_description = $this->page_description();
        return view('edumin.icon.feather', compact('page_title', 'page_description'));
    }
	
	//form-ckeditor
	
	public function form_ckeditor(){
        $page_title = 'Form Ckeditor';
        $page_description = $this->page_description();
        return view('edumin.form.ckeditor', compact('page_title', 'page_description'));
    }
	
	//form-summernote
	
	public function form_editor_summernote(){
        $page_title = 'Ckeditor';
        $page_description = $this->page_description();
        return view('edumin.form.editor_summernote', compact('page_title', 'page_description'));
    }
	
	//form-element
	
	public function form_element(){
        $page_title = 'Form Element';
        $page_description = $this->page_description();
        return view('edumin.form.element', compact('page_title', 'page_description'));
    }
	
	//form-pickers
	
	public function form_pickers(){
        $page_title = 'Form Pickers';
        $page_description = $this->page_description();
        return view('edumin.form.pickers', compact('page_title', 'page_description'));
    }
	
	//form-validation
	
	public function form_validation(){
        $page_title = 'Form validation';
        $page_description = $this->page_description();
        return view('edumin.form.validation', compact('page_title', 'page_description'));
    }
	
	//form-wizard
	
	public function login(){
        $page_title = 'Login';
        $page_description = $this->page_description();
        return view('edumin.page.login', compact('page_title', 'page_description'));
    }
	
	//login
	
	public function form_wizard(){
        $page_title = 'Form wizard';
        $page_description = $this->page_description();
        return view('edumin.form.wizard', compact('page_title', 'page_description'));
    }
	
	//menu
	
	public function menu(){
        $page_title = 'Menu';
        $page_description = $this->page_description();
        return view('edumin.cms.menu', compact('page_title', 'page_description'));
    }
	
	//ap-jqvmap
	
	public function map_jqvmap(){
        $page_title = 'Jqvmap';
        $page_description = $this->page_description();
        return view('edumin.map.jqvmap', compact('page_title', 'page_description'));
    }
	
	
	//page-error-400
	
	public function page_error_400(){
        $page_title = 'Page Error 400';
        $page_description = $this->page_description();
        return view('edumin.page.error_400', compact('page_title', 'page_description'));
    }
	
	//page-error-403
	
	public function page_error_403(){
        $page_title = 'Page Error 403';
        $page_description = $this->page_description();
        return view('edumin.page.error_403', compact('page_title', 'page_description'));
    }
	
	//page-error-404
	
	public function page_error_404(){
        $page_title = 'Page Error 404';
        $page_description = $this->page_description();
        return view('edumin.page.error_404', compact('page_title', 'page_description'));
    }
	
	//page-error-500
	
	public function page_error_500(){
        $page_title = 'Page Error 500';
        $page_description = $this->page_description();
        return view('edumin.page.error_500', compact('page_title', 'page_description'));
    }
	
	//page-error-503
	
	public function page_error_503(){
        $page_title = 'Page Error 503';
        $page_description = $this->page_description();
        return view('edumin.page.error_503', compact('page_title', 'page_description'));
    }
	
	//page-forgot-password
	
	public function page_forgot_password(){
        $page_title = 'Page Forgot Password';
        $page_description = $this->page_description();
        return view('edumin.page.forgot_password', compact('page_title', 'page_description'));
    }
	
	//page-lock-screen
	
	public function page_lock_screen(){
        $page_title = 'Page Lock Screen';
        $page_description = $this->page_description();
        return view('edumin.page.lock_screen', compact('page_title', 'page_description'));
    }
	
	//page-login
	
	public function page_login(){
        $page_title = 'Page Login';
        $page_description = $this->page_description();
        return view('edumin.page.login', compact('page_title', 'page_description'));
    }
	
	//page-register
	
	public function page_register(){
        $page_title = 'Page Register';
        $page_description = $this->page_description();
        return view('edumin.page.register', compact('page_title', 'page_description'));
    }
	
	//svg
	
	public function svg_icons(){
        $page_title = 'Svg Icons';
        $page_description = $this->page_description();
        return view('edumin.icon.svg_icons', compact('page_title', 'page_description'));
    }
	
	//svg icon
	
	public function post_details(){
        $page_title = 'Post Details';
        $page_description = $this->page_description();
        return view('edumin.app.post_details', compact('page_title', 'page_description'));
    }
	
	//table-bootstrap-basic
	public function table_bootstrap_basic(){
        $page_title = 'Bootstrap Basic';
        $page_description = $this->page_description();
        return view('edumin.table.bootstrap_basic', compact('page_title', 'page_description'));
    }
	
	//table-datatable-basic
	
	public function table_datatable_basic(){
        $page_title = 'Datatable Basic';
        $page_description = $this->page_description();
        return view('edumin.table.datatable_basic', compact('page_title', 'page_description'));
    }
	
	//uc-lightgallery
	
	public function uc_lightgallery(){
        $page_title = 'Light Gallery';
        $page_description = $this->page_description();
        return view('edumin.uc.lightgallery', compact('page_title', 'page_description'));
    }
	
	//uc-nestable
	
	public function uc_nestable(){
        $page_title = 'Nestable';
        $page_description = $this->page_description();
        return view('edumin.uc.nestable', compact('page_title', 'page_description'));
    }
	
	//uc-noui-slider
	
	public function uc_noui_slider(){
        $page_title = 'Noui Slider';
        $page_description = $this->page_description();
        return view('edumin.uc.noui_slider', compact('page_title', 'page_description'));
    }
	
	//uc-select2
	
	public function uc_select2(){
        $page_title = 'Select2';
        $page_description = $this->page_description();
        return view('edumin.uc.select2', compact('page_title', 'page_description'));
    }
	
	//uc-sweetalert
	
	public function uc_sweetalert(){
        $page_title = 'Sweet Alert';
        $page_description = $this->page_description();
        return view('edumin.uc.sweetalert', compact('page_title', 'page_description'));
    }
	
	//uc-toastr
	
	public function uc_toastr(){
        $page_title = 'Toastr';
        $page_description = $this->page_description();
        return view('edumin.uc.toastr', compact('page_title', 'page_description'));
    }
	
	//ui-accordion
	
	public function ui_accordion(){
        $page_title = 'Accordion';
        $page_description = $this->page_description();
        return view('edumin.ui.accordion', compact('page_title', 'page_description'));
    }
	
	//ui-alert
	
	public function ui_alert(){
        $page_title = 'Alert';
        $page_description = $this->page_description();
        return view('edumin.ui.alert', compact('page_title', 'page_description'));
    }
	
	//ui-badge
	
	public function ui_badge(){
        $page_title = 'Badge';
        $page_description = $this->page_description();
        return view('edumin.ui.badge', compact('page_title', 'page_description'));
    }
	
	//ui-button
	
	public function ui_button(){
        $page_title = 'Button';
        $page_description = $this->page_description();
        return view('edumin.ui.button', compact('page_title', 'page_description'));
    }
	
	//ui-button-group
	
	public function ui_button_group(){
        $page_title = 'Button';
        $page_description = $this->page_description();
        return view('edumin.ui.button_group', compact('page_title', 'page_description'));
    }
	
	//ui-button-group
	
	public function ui_card(){
        $page_title = 'Card';
        $page_description = $this->page_description();
        return view('edumin.ui.card', compact('page_title', 'page_description'));
    }
	
	//ui-carousel
	
	public function ui_carousel(){
        $page_title = 'Carousel';
        $page_description = $this->page_description();
        return view('edumin.ui.carousel', compact('page_title', 'page_description'));
    }
	
	//ui-dropdown
	
	public function ui_dropdown(){
        $page_title = 'Dropdown';
        $page_description = $this->page_description();
        return view('edumin.ui.dropdown', compact('page_title', 'page_description'));
    }
	
	//ui-grid
	
	public function ui_grid(){
        $page_title = 'Grid';
        $page_description = $this->page_description();
        return view('edumin.ui.grid', compact('page_title', 'page_description'));
    }
	
	//media object
	
	public function ui_media_object(){
        $page_title = 'Media Object';
        $page_description = $this->page_description();
        return view('edumin.ui.media_object', compact('page_title', 'page_description'));
    }
	
	//ui-list-group
	
	public function ui_list_group(){
        $page_title = 'List Group';
        $page_description = $this->page_description();
        return view('edumin.ui.list_group', compact('page_title', 'page_description'));
    }
	
	//ui-modal
	
	public function ui_modal(){
        $page_title = 'Modal';
        $page_description = $this->page_description();
        return view('edumin.ui.modal', compact('page_title', 'page_description'));
    }
	
	//ui-pagination
	
	public function ui_pagination(){
        $page_title = 'Pagination';
        $page_description = $this->page_description();
        return view('edumin.ui.pagination', compact('page_title', 'page_description'));
    }
	
	//ui-popover
	
	public function ui_popover(){
        $page_title = 'Popover';
        $page_description = $this->page_description();
        return view('edumin.ui.popover', compact('page_title', 'page_description'));
    }
	
	//ui-progressbar
	
	public function ui_progressbar(){
        $page_title = 'Progressbar';
        $page_description = $this->page_description();
        return view('edumin.ui.progressbar', compact('page_title', 'page_description'));
    }
	
	//ui-tab
	
	public function ui_tab(){
        $page_title = 'Tab';
        $page_description = $this->page_description();
        return view('edumin.ui.tab', compact('page_title', 'page_description'));
    }
	
	//ui-typography
	
	public function ui_typography(){
        $page_title = 'Tab';
        $page_description = $this->page_description();
        return view('edumin.ui.typography', compact('page_title', 'page_description'));
    }
	
	//widget-basic
	public function widget_basic(){
        $page_title = 'Widget';
        $page_description = $this->page_description();
        return view('edumin.widget.widget_basic', compact('page_title', 'page_description'));
    }
    //ajax_featuredcompanies
	public function ajax_featuredcompanies(){
        return view('edumin.ajax.featuredcompanies');
    }

    //seller_menus
	public function ajax_recentactivity(){
        return view('edumin.ajax.recentactivity');
    }

    
	
	//$page_description = $this->page_description();
	private function page_description() {
		return 'EduMin - Empower your educational institution with the all-in-one Education Admin Dashboard Template. Streamline administrative tasks, manage courses, track student performance, and gain valuable insights with ease. Elevate your education management experience with a modern, responsive, and feature-packed solution. Explore EduMin now for a smarter, more efficient approach to education administration.';
	}
	
	
}
