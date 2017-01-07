angular.module('kaifanla', ['ng', 'ngRoute', 'ngAnimate']).
  controller('parentCtrl', function($scope, $location){
    $scope.jump = function(routeUrl){
      $location.path(routeUrl);
    }
  }).
  controller('startCtrl', function ($scope, $location) {

  }).
  controller('mainCtrl', function ($scope,$http) {
    $scope.hasMore = true;  //是否还有更多数据可供加载
    $scope.dishList = [];  //用于保存所有菜品数据的数组
    //控制器初始化/页面加载时，从服务器读取最前面的5条记录
    $http.get('data/dish_listbypage.php?start=0').
      success(function(data){
        $scope.dishList = $scope.dishList.concat(data);
      });
    //“加载更多”按钮的单击事件处理函数：每点击一次，加载更多的5条数据
    $scope.loadMore = function(){
      $http.get('data/dish_listbypage.php?start='+$scope.dishList.length).
        success(function(data){
          if(data.length<5){  //服务器返回的菜品数量不足5条
            $scope.hasMore = false;
          }
          $scope.dishList = $scope.dishList.concat(data);
        });
    }
    //监视搜索框中的内容是否改变——监视 kw Model变量
    $scope.$watch('kw', function(){
      if( $scope.kw ){
        $http.get('data/dish_listbykw.php?kw='+$scope.kw).
          success(function(data){
            $scope.dishList = data;
          })
      }
    })
  }).
  controller('detailCtrl', function ($scope,$http, $routeParams) {
    //读取路由URL中的参数
    //console.log('detailCtrl读取到下列路由参数：')
    //console.log($routeParams)
    $http.get('data/dish_listbydid.php?did='+$routeParams.did).
      success(function(data){
        //console.log('接收到服务器返回的菜品详情：')
        //console.log(data);
        $scope.dish = data[0];
      })
  }).
  controller('orderCtrl', function($rootScope, $scope,$routeParams,$http){
    //$routeParams.did
    $scope.order = {};
    $scope.order.did = $routeParams.did;
    $scope.order.phone = '13501234567';
    $scope.order.sex = '1';
    $scope.order.user_name = '大旭';
    $scope.order.addr = '万寿路108号';

    $scope.submitOrder = function(){
      //提交订单之前把用户输入的电话号码保存在全局范围内
      $rootScope.phone = $scope.order.phone;
      //把客户端输入的数据转换为“请求参数”格式——k=v&k=v
      var str = jQuery.param($scope.order);

      //发起异步的XHR请求
      //$http.get('data/order_add.php?'+str).success(fn)
      $http.post('data/order_add.php', str).
        success(function(data){
          console.log('读取到服务器返回的响应数据：');
          console.log(data);
          $scope.result = data[0];
        })
    }
  }).
  config(function ($routeProvider) {
    $routeProvider.
      when('/start', {
        templateUrl: 'tpl/start.html',
        controller: 'startCtrl'
      }).
      when('/main', {
        templateUrl: 'tpl/main.html',
        controller: 'mainCtrl'
      }).
      when('/detail/:did', {
        templateUrl: 'tpl/detail.html',
        controller: 'detailCtrl'
      }).
      when('/order/:did', {
        templateUrl: 'tpl/order.html',
        controller: 'orderCtrl'
      }).
      otherwise({
        redirectTo: '/start'
      })
  }).
  run(function($http){
    //设置$http.post请求的默认请求消息头部
    $http.defaults.headers.post = {
      'Content-Type':'application/x-www-form-urlencoded'
    }
  })
