<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'IndexController/index';

$route['translate_uri_dashes'] = FALSE;


                                            /* USER */
/* USER LOGIN */
$route['dang-nhap']['GET'] = 'IndexController/login';
$route['dang-xuat']['GET'] = 'IndexController/logout';
$route['login-customer']['POST'] = 'IndexController/loginCustomer';

/* REGISTER ACCCOUNT */
$route['dang-ky']['POST'] = 'IndexController/dang_ky';
$route['kich-hoat-tai-khoan']['GET'] = 'IndexController/kich_hoat_tai_khoan';

/* RECOVER PASSWORD */
$route['forgot-password-layout']['GET'] = 'IndexController/forgot_password_layout';
$route['customer/forgot-password']['POST'] = 'IndexController/confirm_forgot_password';
$route['lay-lai-mat-khau']['GET'] = 'IndexController/lay_lai_mat_khau';
$route['verify-token-forget-password']['POST'] = 'IndexController/verify_token_forget_password';
$route['nhap-mat-khau-moi']['GET'] = 'IndexController/nhap_mat_khau_moi';
$route['enterNewPassword']['POST'] = 'IndexController/enterNewPassword';
$route['verify-token']['POST'] = 'IndexController/verify_token';
$route['reset-password']['POST'] = 'IndexController/reset_password';

/* CHANGE PASSWORD */
$route['confirmPassword']['GET'] = 'IndexController/confirmPassword';
$route['enterPasswordNow']['POST'] = 'IndexController/enterPasswordNow';
$route['change-password']['GET'] = 'IndexController/change_password';
$route['nhap-ma-xac-thuc']['GET'] = 'IndexController/nhap_ma_xac_thuc';
$route['change-password-verify-token']['POST'] = 'IndexController/change_password_verify_token';
$route['cap-nhat-mat-khau-moi']['GET'] = 'IndexController/cap_nhat_mat_khau_moi';
$route['changePassword']['POST'] = 'IndexController/changePassword';

/* PAGE */
$route['404_override'] = 'IndexController/page_404';
$route['danh-muc/(:any)/(:any)']['GET'] = 'IndexController/category/$1/$2';
$route['thuong-hieu/(:any)/(:any)']['GET'] = 'IndexController/brand/$1/$2';
$route['san-pham/(:any)/(:any)']['GET'] = 'IndexController/product/$1/$2';

/* PAGINATION HOME */
$route['pagination/index']['GET'] = 'IndexController/index';
$route['pagination/index/(:num)']['GET'] = 'IndexController/index/$1';
$route['pagination/danh-muc/(:any)/(:any)']['GET'] = 'IndexController/category/$1/$2';
$route['pagination/danh-muc/(:any)/(:any)/(:any)']['GET'] = 'IndexController/category/$1/$2/$3';
$route['pagination/thuong-hieu/(:any)/(:any)/(:any)']['GET'] = 'IndexController/brand/$1/$2/$3';
$route['pagination/thuong-hieu/(:any)/(:any)']['GET'] = 'IndexController/brand/$1/$2';


/* PRODUCT ON SALE */
$route['product-on-sale']['GET'] = 'IndexController/product_on_sale';
$route['product-on-sale/(:num)']['GET'] = 'IndexController/product_on_sale/$1';

/* CART */
$route['gio-hang']['GET'] = 'IndexController/cart';
$route['add-to-cart']['POST'] = 'IndexController/add_to_cart';
$route['update-cart-item']['POST'] = 'IndexController/update_cart_item';
$route['delete-all-cart']['GET'] = 'IndexController/delete_all_cart';
$route['delete-item/(:any)']['GET'] = 'IndexController/delete_item/$1';


/* CKECKOUT */
$route['checkout']['GET'] = 'IndexController/checkout';
$route['confirm-checkout-method']['POST'] = 'checkoutController/confirm_checkout_method';

/* APPLY COUPON */
$route['apply-coupon']['POST'] = 'IndexController/applyCoupon';



/* LIST ORDER */
$route['order_customer/listOrder']['GET'] = 'IndexController/listOrder';
$route['order_customer/update-order-status']['POST'] = 'OrderController/update_order_status_COD';
$route['order_customer/viewOrder/(:any)']['GET'] = 'IndexController/viewOrder/$1';
$route['order_customer/customerCancelOrder/(:any)']['GET'] = 'OrderController/customerCancelOrder/$1';



/* REVIEW PRODUCT */
$route['review/order/(:any)']['GET'] = 'IndexController/reviewProducts/$1';
$route['review/submitReviews']['POST'] = 'IndexController/submitReviews';



/* THANK PAGE */
$route['thank-you-for-order']['GET'] = 'checkoutController/thank_you_for_order';
$route['thank-you-for-payment']['GET'] = 'checkoutController/thank_you_for_payment';

/* SEARCH PRODUCT */
$route['search-product']['GET'] = 'IndexController/search_product';
$route['search-product/(:any)']['GET'] = 'IndexController/search_product/$1';

/* CUSTOMER INFO */
$route['profile-user']['GET'] = 'IndexController/profile_user';
$route['customer/edit/(:any)']['GET'] = 'IndexController/editCustomer/$1';
$route['customer/update/(:any)']['POST'] = 'IndexController/updateCustomer/$1';
$route['customer/update-avatar/(:any)']['POST'] = 'IndexController/updateAvatarCustomer/$1';

/* SEND MAIL */
$route['send-mail'] = 'IndexController/send_mail';













                                            /* ADMIN */

/* DASHBOARD */
$route['dashboard']['GET'] = 'DashboardController/index';
$route['logout_admin']['GET'] = 'DashboardController/logout';


/* MANAGE CUSTOMER ACCOUNT */
$route['manage-customer/list']['GET'] = 'CustomerController/index';
$route['manage-customer/list/(:num)']['GET'] = 'CustomerController/index/$1';
$route['manage-customer/list/edit/(:any)']['GET'] = 'CustomerController/editCustomer/$1';
$route['manage-customer/update/(:any)']['POST'] = 'CustomerController/updateCustomer/$1';
$route['manage-customer/bulkUpdate']['POST'] = 'CustomerController/bulkUpdateCustomer';

$route['manage-customer/delete/(:any)']['GET'] = 'CustomerController/deleteCustomer/$1';


/* MANAGE ROLE */
$route['manage-role']['GET'] = 'CustomerController/manageRoleUser';
$route['manage-role/(:num)']['GET'] = 'CustomerController/manageRoleUser/$1';
$route['manage-role/edit/(:any)']['GET'] = 'CustomerController/editRole/$1';
$route['manage-role/update/(:any)']['POST'] = 'CustomerController/updateRole/$1';

/* REGISTER ADMIN ACCCOUNT */
// $route['login-admin']['POST'] = 'loginController/loginAdmin';
// $route['register-admin']['GET'] = 'loginController/register_admin';
// $route['register-admin-submit']['POST'] = 'loginController/insert_admin';

/* MANAGE BRAND */
$route['brand/list']['GET'] = 'BrandController/index';
$route['brand/list/(:num)']['GET'] = 'BrandController/index/$1';
$route['brand/list/edit/(:any)']['GET'] = 'BrandController/editBrand/$1';
$route['brand/create']['GET'] = 'BrandController/createBrand';
$route['brand/storage']['POST'] = 'BrandController/storageBrand';
$route['brand/update/(:any)']['POST'] = 'BrandController/updateBrand/$1';
$route['brand/list/bulkUpdate']['POST'] = 'BrandController/bulkUpdateBrand';
// $route['brand/delete/(:any)']['GET'] = 'BrandController/deleteBrand/$1';

/* MANAGE CATEGORY */
$route['category/list']['GET'] = 'CategoryController/index';
$route['category/list/(:num)']['GET'] = 'CategoryController/index/$1';
$route['category/list/edit/(:any)']['GET'] = 'CategoryController/editCategory/$1';
$route['category/create']['GET'] = 'CategoryController/createCategory';
$route['category/storage']['POST'] = 'CategoryController/storageCategory';
$route['category/update/(:any)']['POST'] = 'CategoryController/updateCategory/$1';
$route['category/list/bulkUpdate']['POST'] = 'CategoryController/bulkUpdateCategory';
// $route['category/delete/(:any)']['GET'] = 'CategoryController/deleteCategory/$1';

/* MANAGE SLIDER */
$route['slider/list']['GET'] = 'SliderController/index';
$route['slider/list/edit/(:any)']['GET'] = 'SliderController/editSlider/$1';
$route['slider/create']['GET'] = 'SliderController/createSlider';
$route['slider/store']['POST'] = 'SliderController/storeSlider';
$route['slider/update/(:any)']['POST'] = 'SliderController/updateSlider/$1';
$route['slider/delete/(:any)']['GET'] = 'SliderController/deleteSlider/$1';

/* MANAGE PRODUCT */
$route['product/list']['GET'] = 'ProductController/index';
$route['product/list/(:num)']['GET'] = 'ProductController/index/$1';
$route['product/list/edit/(:any)']['GET'] = 'ProductController/editProduct/$1';
$route['product/create']['GET'] = 'ProductController/createProduct';
$route['product/store']['POST'] = 'ProductController/storeProduct';
$route['product/update/(:any)']['POST'] = 'ProductController/updateProduct/$1';
$route['product/list/bulkUpdate']['POST'] = 'ProductController/bulkUpdateProduct';

$route['product/delete/(:any)']['GET'] = 'ProductController/deleteProduct/$1';



/* MANAGE SUPPLIERS */
$route['supplier/list']['GET'] = 'SupplierController/index';
$route['supplier/list/(:num)']['GET'] = 'SupplierController/index/$1';
$route['supplier/list/edit/(:any)']['GET'] = 'SupplierController/editSupplier/$1';
$route['supplier/create']['GET'] = 'SupplierController/createSupplier';
$route['supplier/storage']['POST'] = 'SupplierController/storageSupplier';
$route['supplier/update/(:any)']['POST'] = 'SupplierController/updateSupplier/$1';
$route['supplier/list/bulkUpdate']['POST'] = 'SupplierController/bulkUpdateSupplier';



/* MANAGE WAREHOUSE */
$route['warehouse/list']['GET'] = 'WarehouseController/index';
$route['warehouse/list/(:num)']['GET'] = 'WarehouseController/index/$1';
$route['warehouse/receive-goods']['GET'] = 'WarehouseController/receive_goods_page';
$route['warehouse/receive-goods/enter-into-warehouse']['POST'] = 'WarehouseController/enter_into_warehouse';
$route['warehouse/receive-goods-history']['GET'] = 'WarehouseController/receipt_goods_history';
$route['warehouse/receive-goods-history/(:num)']['GET'] = 'WarehouseController/receipt_goods_history/$1';
$route['warehouse/receive-goods-history/receipt_detail/(:any)']['GET'] = 'WarehouseController/receipt_detail/$1';
$route['receive-goods/bulkPrint']['POST'] = 'WarehouseController/bulkPrintReceipts';


/* MANAGE ORDER */
$route['order_admin/listOrder']['GET'] = 'OrderController/index';
$route['order_admin/listOrder/(:num)']['GET'] = 'OrderController/index/$1';
$route['order_admin/update-order-status']['POST'] = 'OrderController/update_order_status';
$route['order_admin/bulkUpdate']['POST'] = 'OrderController/bulkUpdate';
$route['order_admin/viewOrder/(:any)']['GET'] = 'OrderController/viewOrder/$1';
$route['order_admin/printOrder/(:any)']['GET'] = 'OrderController/printOrder/$1';
$route['order_admin/bulkPrint']['POST'] = 'OrderController/bulkPrint';
// $route['order_admin/deleteOrder/(:any)']['GET'] = 'OrderController/deleteOrder/$1';

/* MANAGE COMMENT */
$route['comment/send']['POST'] = 'DashboardController/comment_send';
$route['comment']['GET'] = 'DashboardController/list_comment';
$route['comment/list/edit/(:any)']['GET'] = 'DashboardController/editComment/$1';
$route['comment/update/(:any)']['POST'] = 'DashboardController/updateComment/$1';
$route['comment/delete/(:any)']['GET'] = 'DashboardController/deleteComment/$1';


/* MANAGE REVIEWS */
$route['review-list']['GET'] = 'ReviewController/index';
$route['review-list/(:num)']['GET'] = 'ReviewController/index/$1';
$route['review-list/detail/(:num)']['GET'] = 'ReviewController/reviewProduct/$1';
$route['review-list/detail/(:num)/(:num)']['GET'] = 'ReviewController/reviewProduct/$1/$2';
$route['reply-comment']['POST'] = 'ReviewController/updateReview';


/* MANAGE DISCOUNT CODE */


$route['discount-code/list']['GET'] = 'DashboardController/discount_code_list';
$route['discount-code/list/(:num)']['GET'] = 'DashboardController/discount_code_list/$1';
$route['discount-code/list/edit/(:any)']['GET'] = 'DashboardController/discount_code_edit/$1';
$route['discount-code/create']['GET'] = 'DashboardController/createDiscountCode';
$route['discount-code/storage']['POST'] = 'DashboardController/storageDiscountCode';
$route['discount-code/update/(:any)']['POST'] = 'DashboardController/updateDiscountCode/$1';
$route['discount-code/list/bulkUpdate']['POST'] = 'DashboardController/bulkUpdateDiscountCode';
$route['discount-code/delete/(:any)']['GET'] = 'DashboardController/deleteDiscountCode/$1';
// $route['discount-code-list']['GET'] = 'DashboardController/discount_code_list';
// $route['discount-code-list/(:num)']['GET'] = 'DashboardController/discount_code_list/$1';







/* REVENUE */
// $route['revenue']['GET'] = 'RevenueController/index';
// $route['revenue-custom']['POST'] = 'RevenueController/customRevenue';
// $route['revenuee']['GET'] = 'RevenueController/revenuee';
// $route['revenueee']['POST'] = 'RevenueController/revenueee';

$route['revenueReport']['GET'] = 'RevenueController/revenueReportPage';
$route['revenueBatches']['GET'] = 'RevenueController/revenueBatchesPage';





/* AI CHẨN ĐOÁN BỆNH */
$route['predict']['GET'] = 'PredictController/yolo_predict_page';
$route['predict']['POST'] = 'PredictController/yolo_predict_page';
$route['predict/(:num)']['GET']  = 'PredictController/yolo_predict_page/$1';
$route['predict/(:num)']['POST'] = 'PredictController/yolo_predict_page/$1';