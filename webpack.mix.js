let mix = require('laravel-mix');

const Dotenv = require('dotenv-webpack');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 */

// let dotenvplugin = new webpack.DefinePlugin({
//   'process.env': {
//       APP_NAME: JSON.stringify(process.env.APP_NAME || 'Default app name'),
//       NODE_ENV: JSON.stringify(process.env.NODE_ENV || 'development')
//   }
// })

if (mix.inProduction()) {
  mix.react('src/App.jsx', 'dist/')
  .react('src/App_Login.jsx', 'dist/')
  .react('src/App_modify.jsx', 'dist/')
  .react('src/App_PC_776.jsx', 'dist/')
  .react('src/App_Category.jsx', 'dist/')
  .react('src/App_Fan_Event.jsx', 'dist/')
  .react('src/App_Magazine.jsx', 'dist/')
  .react('src/App_Top_Banner.jsx', 'dist/')
  .react('src/App_Event.jsx', 'dist/')
  .sass('src/res/css/Global.scss', 'dist/css/')
  .sass('src/res/css/StoreHome.scss', 'dist/css/')
  .sass('src/res/css/StoreContentsListItem.scss', 'dist/css/')
  .sass('src/res/css/StoreDetailPage.scss', 'dist/css/')
  .sass('src/res/css/StoreReviewList.scss', 'dist/css/')
  .sass('src/res/css/StoreReviewItem.scss', 'dist/css/')
  .sass('src/res/css/ReviewWritePage.scss', 'dist/css/')
  .sass('src/res/css/StoreItemDetailPage.scss', 'dist/css/')
  .sass('src/res/css/StoreOrderPage.scss', 'dist/css/')
  .sass('src/res/css/StoreOrderItem.scss', 'dist/css/')
  .sass('src/res/css/StoreOrderComplitePage.scss', 'dist/css/')
  .sass('src/res/css/StoreReceiptItem.scss', 'dist/css/')
  .sass('src/res/css/StoreDetailReceipt.scss', 'dist/css/')
  .sass('src/res/css/MyContentsPage.scss', 'dist/css/')
  .sass('src/res/css/StoreManager.scss', 'dist/css/')
  .sass('src/res/css/StoreManagerTabAskOrderListPage.scss', 'dist/css/')
  .sass('src/res/css/FileUploader.scss', 'dist/css/')
  .sass('src/res/css/StoreManagerTabStoreInfoPage.scss', 'dist/css/')
  .sass('src/res/css/StoreManagerTabItemPage.scss', 'dist/css/')
  .sass('src/res/css/StoreAddItemPage.scss', 'dist/css/')
  .sass('src/res/css/StoreManagerTabOrderListPage.scss', 'dist/css/')
  .sass('src/res/css/StoreManagerTabAccountPage.scss', 'dist/css/')
  .sass('src/res/css/StoreUserSNSList.scss', 'dist/css/')
  .sass('src/res/css/StoreHomeStoreListItem.scss', 'dist/css/')
  .sass('src/res/css/Popup_progress.scss', 'dist/css/')
  .sass('src/res/css/Popup_image_preview.scss', 'dist/css/')
  .sass('src/res/css/Popup_text_editor.scss', 'dist/css/')
  .sass('src/res/css/StoreContentConfirm.scss', 'dist/css/')
  .sass('src/res/css/Popup_text_viewer.scss', 'dist/css/')
  .sass('src/res/css/StoreISPOrderComplitePage.scss', 'dist/css/')
  .sass('src/res/css/StoreStateProcess.scss', 'dist/css/')
  .sass('src/res/css/StorePlayTimePlan.scss', 'dist/css/')
  .sass('src/res/css/Popup_SelectTime.scss', 'dist/css/')
  .sass('src/res/css/TableComponent.scss', 'dist/css/')
  .sass('src/res/css/StoreOtherItems.scss', 'dist/css/')
  .sass('src/res/css/StoreReviewTalk.scss', 'dist/css/')
  .sass('src/res/css/StoreReviewTalkItem.scss', 'dist/css/')
  .sass('src/res/css/ImageFileUploader.scss', 'dist/css/')
  .sass('src/res/css/Popup_refund.scss', 'dist/css/')
  .sass('src/res/css/StoreItemDetailReviewList.scss', 'dist/css/')
  .sass('src/res/css/StoreItemDetailReviewItem.scss', 'dist/css/')
  .sass('src/res/css/ImageCroper.scss', 'dist/css/')
  .sass('src/res/css/StoreManagerTabHomePage.scss', 'dist/css/')
  .sass('src/res/css/StoreDoIt.scss', 'dist/css/')
  .sass('src/res/css/StoreManagerHome_Item.scss', 'dist/css/')
  .sass('src/res/css/StoreManagerHome_newOrderItem.scss', 'dist/css/')
  .sass('src/res/css/Popup_StoreReceiptItem.scss', 'dist/css/')
  .sass('src/res/css/Profile.scss', 'dist/css/')
  .sass('src/res/css/Footer_React.scss', 'dist/css/')
  .sass('src/res/css/Home_Thumb_list.scss', 'dist/css/')
  .sass('src/res/css/Home_Thumb_Popular_item.scss', 'dist/css/')
  .sass('src/res/css/Home_Thumb_Product_Label.scss', 'dist/css/')
  .sass('src/res/css/Home_Thumb_Recommend_Creator_List.scss', 'dist/css/')
  .sass('src/res/css/Home_Thumb_Tag.scss', 'dist/css/')
  .sass('src/res/css/Home_Thumb_Attention_Item.scss', 'dist/css/')
  .sass('src/res/css/Home_Thumb_Container_List.scss', 'dist/css/')
  .sass('src/res/css/Home_Thumb_Container_Item.scss', 'dist/css/')
  .sass('src/res/css/Home_Thumb_Stores_Item.scss', 'dist/css/')
  .sass('src/res/css/SearchPage.scss', 'dist/css/')
  .sass('src/res/css/SearchResultPage.scss', 'dist/css/')
  .sass('src/res/css/Find_Result_Stores_item.scss', 'dist/css/')
  .sass('src/res/css/Home_Thumb_Container_Project_Item.scss', 'dist/css/')
  .sass('src/res/css/Thumb_Recommend_item.scss', 'dist/css/')
  .sass('src/res/css/Home_Top_Banner.scss', 'dist/css/')
  .sass('src/res/css/Carousel_Item_Counting.scss', 'dist/css/')
  .sass('src/res/css/CompletedFileUpLoader.scss', 'dist/css/')
  .sass('src/res/css/Popup_resetSendMail.scss', 'dist/css/')
  .sass('src/res/css/LoginStartPage.scss', 'dist/css/')
  .sass('src/res/css/PageLoginController.scss', 'dist/css/')
  .sass('src/res/css/LoginEmailPage.scss', 'dist/css/')
  .sass('src/res/css/LoginKnowSNSPage.scss', 'dist/css/')
  .sass('src/res/css/LoginResetPasswordPage.scss', 'dist/css/')
  .sass('src/res/css/LoginForgetEmailPage.scss', 'dist/css/')
  .sass('src/res/css/LoginSNSSetEmailPage.scss', 'dist/css/')
  .sass('src/res/css/LoginJoinPage.scss', 'dist/css/')
  .sass('src/res/css/App_modify.scss', 'dist/css/')
  .sass('src/res/css/InputBox.scss', 'dist/css/')
  .sass('src/res/css/PasswordResetPage.scss', 'dist/css/')
  .sass('src/res/css/WithdrawalPage.scss', 'dist/css/')
  .sass('src/res/css/Page_pc_776_Controller.scss', 'dist/css/')
  .sass('src/res/css/Category_Selecter.scss', 'dist/css/')
  .sass('src/res/css/App_Category.scss', 'dist/css/')
  .sass('src/res/css/Category_Top_Carousel.scss', 'dist/css/')
  .sass('src/res/css/Category_Top_Carousel_Item.scss', 'dist/css/')
  .sass('src/res/css/Category_Result_List.scss', 'dist/css/')
  .sass('src/res/css/Category_Creator_List.scss', 'dist/css/')
  .sass('src/res/css/Popup_category_filter.scss', 'dist/css/')
  .sass('src/res/css/Popup_category_sort.scss', 'dist/css/')
  .sass('src/res/css/Popup_category_info.scss', 'dist/css/')
  .sass('src/res/css/SelectBoxLanguage.scss', 'dist/css/')
  .sass('src/res/css/App_Fan_Event.scss', 'dist/css/')
  .sass('src/res/css/Thumb_Project_Item.scss', 'dist/css/')
  .sass('src/res/css/Fan_Project_List.scss', 'dist/css/')
  .sass('src/res/css/App_Magazine.scss', 'dist/css/')
  .sass('src/res/css/Magazine_List_Item.scss', 'dist/css/')
  .sass('src/res/css/PhoneConfirm.scss', 'dist/css/')
  .sass('src/res/css/InActivePage.scss', 'dist/css/')
  .sass('src/res/css/App_Top_Banner.scss', 'dist/css/')
  .sass('src/res/css/App_Event.scss', 'dist/css/')
  .webpackConfig({
    plugins: [
      new Dotenv()
    ],
  });
  /* production UP */
}else{
  mix.react('src/App.jsx', 'dist/')
  .react('src/App_Login.jsx', 'dist/')
  .react('src/App_modify.jsx', 'dist/')
  .react('src/App_PC_776.jsx', 'dist/')
  .react('src/App_Category.jsx', 'dist/')
  .react('src/App_Fan_Event.jsx', 'dist/')
  .react('src/App_Magazine.jsx', 'dist/')
  .react('src/App_Top_Banner.jsx', 'dist/')
  .react('src/App_Event.jsx', 'dist/')
  .sass('src/res/css/Global.scss', 'dist/css/')
  .sass('src/res/css/StoreHome.scss', 'dist/css/')
  .sass('src/res/css/StoreContentsListItem.scss', 'dist/css/')
  .sass('src/res/css/StoreDetailPage.scss', 'dist/css/')
  .sass('src/res/css/StoreReviewList.scss', 'dist/css/')
  .sass('src/res/css/StoreReviewItem.scss', 'dist/css/')
  .sass('src/res/css/ReviewWritePage.scss', 'dist/css/')
  .sass('src/res/css/StoreItemDetailPage.scss', 'dist/css/')
  .sass('src/res/css/StoreOrderPage.scss', 'dist/css/')
  .sass('src/res/css/StoreOrderItem.scss', 'dist/css/')
  .sass('src/res/css/StoreOrderComplitePage.scss', 'dist/css/')
  .sass('src/res/css/StoreReceiptItem.scss', 'dist/css/')
  .sass('src/res/css/StoreDetailReceipt.scss', 'dist/css/')
  .sass('src/res/css/MyContentsPage.scss', 'dist/css/')
  .sass('src/res/css/StoreManager.scss', 'dist/css/')
  .sass('src/res/css/StoreManagerTabAskOrderListPage.scss', 'dist/css/')
  .sass('src/res/css/FileUploader.scss', 'dist/css/')
  .sass('src/res/css/StoreManagerTabStoreInfoPage.scss', 'dist/css/')
  .sass('src/res/css/StoreManagerTabItemPage.scss', 'dist/css/')
  .sass('src/res/css/StoreAddItemPage.scss', 'dist/css/')
  .sass('src/res/css/StoreManagerTabOrderListPage.scss', 'dist/css/')
  .sass('src/res/css/StoreManagerTabAccountPage.scss', 'dist/css/')
  .sass('src/res/css/StoreUserSNSList.scss', 'dist/css/')
  .sass('src/res/css/StoreHomeStoreListItem.scss', 'dist/css/')
  .sass('src/res/css/Popup_progress.scss', 'dist/css/')
  .sass('src/res/css/Popup_image_preview.scss', 'dist/css/')
  .sass('src/res/css/Popup_text_editor.scss', 'dist/css/')
  .sass('src/res/css/StoreContentConfirm.scss', 'dist/css/')
  .sass('src/res/css/Popup_text_viewer.scss', 'dist/css/')
  .sass('src/res/css/StoreISPOrderComplitePage.scss', 'dist/css/')
  .sass('src/res/css/StoreStateProcess.scss', 'dist/css/')
  .sass('src/res/css/StorePlayTimePlan.scss', 'dist/css/')
  .sass('src/res/css/Popup_SelectTime.scss', 'dist/css/')
  .sass('src/res/css/TableComponent.scss', 'dist/css/')
  .sass('src/res/css/StoreOtherItems.scss', 'dist/css/')
  .sass('src/res/css/StoreReviewTalk.scss', 'dist/css/')
  .sass('src/res/css/StoreReviewTalkItem.scss', 'dist/css/')
  .sass('src/res/css/ImageFileUploader.scss', 'dist/css/')
  .sass('src/res/css/Popup_refund.scss', 'dist/css/')
  .sass('src/res/css/StoreItemDetailReviewList.scss', 'dist/css/')
  .sass('src/res/css/StoreItemDetailReviewItem.scss', 'dist/css/')
  .sass('src/res/css/ImageCroper.scss', 'dist/css/')
  .sass('src/res/css/StoreManagerTabHomePage.scss', 'dist/css/')
  .sass('src/res/css/StoreDoIt.scss', 'dist/css/')
  .sass('src/res/css/StoreManagerHome_Item.scss', 'dist/css/')
  .sass('src/res/css/StoreManagerHome_newOrderItem.scss', 'dist/css/')
  .sass('src/res/css/Popup_StoreReceiptItem.scss', 'dist/css/')
  .sass('src/res/css/Profile.scss', 'dist/css/')
  .sass('src/res/css/Footer_React.scss', 'dist/css/')
  .sass('src/res/css/Home_Thumb_list.scss', 'dist/css/')
  .sass('src/res/css/Home_Thumb_Popular_item.scss', 'dist/css/')
  .sass('src/res/css/Home_Thumb_Product_Label.scss', 'dist/css/')
  .sass('src/res/css/Home_Thumb_Recommend_Creator_List.scss', 'dist/css/')
  .sass('src/res/css/Home_Thumb_Tag.scss', 'dist/css/')
  .sass('src/res/css/Home_Thumb_Attention_Item.scss', 'dist/css/')
  .sass('src/res/css/Home_Thumb_Container_List.scss', 'dist/css/')
  .sass('src/res/css/Home_Thumb_Container_Item.scss', 'dist/css/')
  .sass('src/res/css/Home_Thumb_Stores_Item.scss', 'dist/css/')
  .sass('src/res/css/SearchPage.scss', 'dist/css/')
  .sass('src/res/css/SearchResultPage.scss', 'dist/css/')
  .sass('src/res/css/Find_Result_Stores_item.scss', 'dist/css/')
  .sass('src/res/css/Home_Thumb_Container_Project_Item.scss', 'dist/css/')
  .sass('src/res/css/Thumb_Recommend_item.scss', 'dist/css/')
  .sass('src/res/css/Home_Top_Banner.scss', 'dist/css/')
  .sass('src/res/css/Carousel_Item_Counting.scss', 'dist/css/')
  .sass('src/res/css/CompletedFileUpLoader.scss', 'dist/css/')
  .sass('src/res/css/Popup_resetSendMail.scss', 'dist/css/')
  .sass('src/res/css/LoginStartPage.scss', 'dist/css/')
  .sass('src/res/css/PageLoginController.scss', 'dist/css/')
  .sass('src/res/css/LoginEmailPage.scss', 'dist/css/')
  .sass('src/res/css/LoginKnowSNSPage.scss', 'dist/css/')
  .sass('src/res/css/LoginResetPasswordPage.scss', 'dist/css/')
  .sass('src/res/css/LoginForgetEmailPage.scss', 'dist/css/')
  .sass('src/res/css/LoginSNSSetEmailPage.scss', 'dist/css/')
  .sass('src/res/css/LoginJoinPage.scss', 'dist/css/')
  .sass('src/res/css/App_modify.scss', 'dist/css/')
  .sass('src/res/css/InputBox.scss', 'dist/css/')
  .sass('src/res/css/PasswordResetPage.scss', 'dist/css/')
  .sass('src/res/css/WithdrawalPage.scss', 'dist/css/')
  .sass('src/res/css/Page_pc_776_Controller.scss', 'dist/css/')
  .sass('src/res/css/Category_Selecter.scss', 'dist/css/')
  .sass('src/res/css/App_Category.scss', 'dist/css/')
  .sass('src/res/css/Category_Top_Carousel.scss', 'dist/css/')
  .sass('src/res/css/Category_Top_Carousel_Item.scss', 'dist/css/')
  .sass('src/res/css/Category_Result_List.scss', 'dist/css/')
  .sass('src/res/css/Category_Creator_List.scss', 'dist/css/')
  .sass('src/res/css/Popup_category_filter.scss', 'dist/css/')
  .sass('src/res/css/Popup_category_sort.scss', 'dist/css/')
  .sass('src/res/css/Popup_category_info.scss', 'dist/css/')
  .sass('src/res/css/SelectBoxLanguage.scss', 'dist/css/')
  .sass('src/res/css/App_Fan_Event.scss', 'dist/css/')
  .sass('src/res/css/Thumb_Project_Item.scss', 'dist/css/')
  .sass('src/res/css/Fan_Project_List.scss', 'dist/css/')
  .sass('src/res/css/App_Magazine.scss', 'dist/css/')
  .sass('src/res/css/Magazine_List_Item.scss', 'dist/css/')
  .sass('src/res/css/PhoneConfirm.scss', 'dist/css/')
  .sass('src/res/css/InActivePage.scss', 'dist/css/')
  .sass('src/res/css/App_Top_Banner.scss', 'dist/css/')
  .sass('src/res/css/App_Event.scss', 'dist/css/')
  .webpackConfig({
    plugins: [
      new Dotenv()
    ],
    devtool: 'inline-source-map'
  }).sourceMaps().version();
}
/*DEV UP */

/*
mix.react('src/App.jsx', 'dist/')
.react('src/App_Login.jsx', 'dist/')
.react('src/App_modify.jsx', 'dist/')
.react('src/App_PC_776.jsx', 'dist/')
.react('src/App_Category.jsx', 'dist/')
.react('src/App_Fan_Event.jsx', 'dist/')
.react('src/App_Magazine.jsx', 'dist/')
.sass('src/res/css/Global.scss', 'dist/css/')
.sass('src/res/css/StoreHome.scss', 'dist/css/')
.sass('src/res/css/StoreContentsListItem.scss', 'dist/css/')
.sass('src/res/css/StoreDetailPage.scss', 'dist/css/')
.sass('src/res/css/StoreReviewList.scss', 'dist/css/')
.sass('src/res/css/StoreReviewItem.scss', 'dist/css/')
.sass('src/res/css/ReviewWritePage.scss', 'dist/css/')
.sass('src/res/css/StoreItemDetailPage.scss', 'dist/css/')
.sass('src/res/css/StoreOrderPage.scss', 'dist/css/')
.sass('src/res/css/StoreOrderItem.scss', 'dist/css/')
.sass('src/res/css/StoreOrderComplitePage.scss', 'dist/css/')
.sass('src/res/css/StoreReceiptItem.scss', 'dist/css/')
.sass('src/res/css/StoreDetailReceipt.scss', 'dist/css/')
.sass('src/res/css/MyContentsPage.scss', 'dist/css/')
.sass('src/res/css/StoreManager.scss', 'dist/css/')
.sass('src/res/css/StoreManagerTabAskOrderListPage.scss', 'dist/css/')
.sass('src/res/css/FileUploader.scss', 'dist/css/')
.sass('src/res/css/StoreManagerTabStoreInfoPage.scss', 'dist/css/')
.sass('src/res/css/StoreManagerTabItemPage.scss', 'dist/css/')
.sass('src/res/css/StoreAddItemPage.scss', 'dist/css/')
.sass('src/res/css/StoreManagerTabOrderListPage.scss', 'dist/css/')
.sass('src/res/css/StoreManagerTabAccountPage.scss', 'dist/css/')
.sass('src/res/css/StoreUserSNSList.scss', 'dist/css/')
.sass('src/res/css/StoreHomeStoreListItem.scss', 'dist/css/')
.sass('src/res/css/Popup_progress.scss', 'dist/css/')
.sass('src/res/css/Popup_image_preview.scss', 'dist/css/')
.sass('src/res/css/Popup_text_editor.scss', 'dist/css/')
.sass('src/res/css/StoreContentConfirm.scss', 'dist/css/')
.sass('src/res/css/Popup_text_viewer.scss', 'dist/css/')
.sass('src/res/css/StoreISPOrderComplitePage.scss', 'dist/css/')
.sass('src/res/css/EventPage.scss', 'dist/css/')
.sass('src/res/css/StoreStateProcess.scss', 'dist/css/')
.sass('src/res/css/StorePlayTimePlan.scss', 'dist/css/')
.sass('src/res/css/Popup_SelectTime.scss', 'dist/css/')
.sass('src/res/css/TableComponent.scss', 'dist/css/')
.sass('src/res/css/StoreOtherItems.scss', 'dist/css/')
.sass('src/res/css/StoreReviewTalk.scss', 'dist/css/')
.sass('src/res/css/StoreReviewTalkItem.scss', 'dist/css/')
.sass('src/res/css/ImageFileUploader.scss', 'dist/css/')
.sass('src/res/css/Popup_refund.scss', 'dist/css/')
.sass('src/res/css/StoreItemDetailReviewList.scss', 'dist/css/')
.sass('src/res/css/StoreItemDetailReviewItem.scss', 'dist/css/')
.sass('src/res/css/ImageCroper.scss', 'dist/css/')
.sass('src/res/css/StoreManagerTabHomePage.scss', 'dist/css/')
.sass('src/res/css/StoreDoIt.scss', 'dist/css/')
.sass('src/res/css/StoreManagerHome_Item.scss', 'dist/css/')
.sass('src/res/css/StoreManagerHome_newOrderItem.scss', 'dist/css/')
.sass('src/res/css/Popup_StoreReceiptItem.scss', 'dist/css/')
.sass('src/res/css/Profile.scss', 'dist/css/')
.sass('src/res/css/Footer_React.scss', 'dist/css/')
.sass('src/res/css/Home_Thumb_list.scss', 'dist/css/')
.sass('src/res/css/Home_Thumb_Popular_item.scss', 'dist/css/')
.sass('src/res/css/Home_Thumb_Product_Label.scss', 'dist/css/')
.sass('src/res/css/Home_Thumb_Recommend_Creator_List.scss', 'dist/css/')
.sass('src/res/css/Home_Thumb_Tag.scss', 'dist/css/')
.sass('src/res/css/Home_Thumb_Attention_Item.scss', 'dist/css/')
.sass('src/res/css/Home_Thumb_Container_List.scss', 'dist/css/')
.sass('src/res/css/Home_Thumb_Container_Item.scss', 'dist/css/')
.sass('src/res/css/Home_Thumb_Stores_Item.scss', 'dist/css/')
.sass('src/res/css/SearchPage.scss', 'dist/css/')
.sass('src/res/css/SearchResultPage.scss', 'dist/css/')
.sass('src/res/css/Find_Result_Stores_item.scss', 'dist/css/')
.sass('src/res/css/Home_Thumb_Container_Project_Item.scss', 'dist/css/')
.sass('src/res/css/Thumb_Recommend_item.scss', 'dist/css/')
.sass('src/res/css/Home_Top_Banner.scss', 'dist/css/')
.sass('src/res/css/Carousel_Item_Counting.scss', 'dist/css/')
.sass('src/res/css/CompletedFileUpLoader.scss', 'dist/css/')
.sass('src/res/css/Popup_resetSendMail.scss', 'dist/css/')
.sass('src/res/css/LoginStartPage.scss', 'dist/css/')
.sass('src/res/css/PageLoginController.scss', 'dist/css/')
.sass('src/res/css/LoginEmailPage.scss', 'dist/css/')
.sass('src/res/css/LoginKnowSNSPage.scss', 'dist/css/')
.sass('src/res/css/LoginResetPasswordPage.scss', 'dist/css/')
.sass('src/res/css/LoginForgetEmailPage.scss', 'dist/css/')
.sass('src/res/css/LoginSNSSetEmailPage.scss', 'dist/css/')
.sass('src/res/css/LoginJoinPage.scss', 'dist/css/')
.sass('src/res/css/App_modify.scss', 'dist/css/')
.sass('src/res/css/InputBox.scss', 'dist/css/')
.sass('src/res/css/PasswordResetPage.scss', 'dist/css/')
.sass('src/res/css/WithdrawalPage.scss', 'dist/css/')
.sass('src/res/css/Page_pc_776_Controller.scss', 'dist/css/')
.sass('src/res/css/Category_Selecter.scss', 'dist/css/')
.sass('src/res/css/App_Category.scss', 'dist/css/')
.sass('src/res/css/Category_Top_Carousel.scss', 'dist/css/')
.sass('src/res/css/Category_Top_Carousel_Item.scss', 'dist/css/')
.sass('src/res/css/Category_Result_List.scss', 'dist/css/')
.sass('src/res/css/Category_Creator_List.scss', 'dist/css/')
.sass('src/res/css/Popup_category_filter.scss', 'dist/css/')
.sass('src/res/css/Popup_category_sort.scss', 'dist/css/')
.sass('src/res/css/Popup_category_info.scss', 'dist/css/')
.sass('src/res/css/SelectBoxLanguage.scss', 'dist/css/')
.sass('src/res/css/App_Fan_Event.scss', 'dist/css/')
.sass('src/res/css/Thumb_Project_Item.scss', 'dist/css/')
.sass('src/res/css/Fan_Project_List.scss', 'dist/css/')
.sass('src/res/css/App_Magazine.scss', 'dist/css/')
.sass('src/res/css/Magazine_List_Item.scss', 'dist/css/')
.sass('src/res/css/PhoneConfirm.scss', 'dist/css/')
.sass('src/res/css/InActivePage.scss', 'dist/css/')
.webpackConfig({
  plugins: [
    new Dotenv()
  ],
  devtool: 'inline-source-map'
// });
}).sourceMaps().version();
*/
// mix.react('src/App.jsx', 'dist/').version();

// Full API
// mix.js(src, output);
// mix.react(src, output); <-- Identical to mix.js(), but registers React Babel compilation.
// mix.preact(src, output); <-- Identical to mix.js(), but registers Preact compilation.
// mix.coffee(src, output); <-- Identical to mix.js(), but registers CoffeeScript compilation.
// mix.ts(src, output); <-- TypeScript support. Requires tsconfig.json to exist in the same folder as webpack.mix.js
// mix.extract(vendorLibs);
// mix.sass(src, output);
// mix.less(src, output);
// mix.stylus(src, output);
// mix.postCss(src, output, [require('postcss-some-plugin')()]);
// mix.browserSync('my-site.test');
// mix.combine(files, destination);
// mix.babel(files, destination); <-- Identical to mix.combine(), but also includes Babel compilation.
// mix.copy(from, to);
// mix.copyDirectory(fromDir, toDir);
// mix.minify(file);
// mix.sourceMaps(); // Enable sourcemaps
// mix.version(); // Enable versioning.
// mix.disableNotifications();
// mix.setPublicPath('path/to/public');
// mix.setResourceRoot('prefix/for/resource/locators');
// mix.autoload({}); <-- Will be passed to Webpack's ProvidePlugin.
// mix.webpackConfig({}); <-- Override webpack.config.js, without editing the file directly.
// mix.babelConfig({}); <-- Merge extra Babel configuration (plugins, etc.) with Mix's default.
// mix.then(function () {}) <-- Will be triggered each time Webpack finishes building.
// mix.when(condition, function (mix) {}) <-- Call function if condition is true.
// mix.override(function (webpackConfig) {}) <-- Will be triggered once the webpack config object has been fully generated by Mix.
// mix.dump(); <-- Dump the generated webpack config object to the console.
// mix.extend(name, handler) <-- Extend Mix's API with your own components.
// mix.options({
//   extractVueStyles: false, // Extract .vue component styling to file, rather than inline.
//   globalVueStyles: file, // Variables file to be imported in every component.
//   processCssUrls: true, // Process/optimize relative stylesheet url()'s. Set to false, if you don't want them touched.
//   purifyCss: false, // Remove unused CSS selectors.
//   terser: {}, // Terser-specific options. https://github.com/webpack-contrib/terser-webpack-plugin#options
//   postCss: [] // Post-CSS options: https://github.com/postcss/postcss/blob/master/docs/plugins.md
// });
