<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <title>后台管理| {{ env('APP_NAME') }}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/backend/layui/css/layui.css">
    <link rel="stylesheet" href="/backend/plugins/fontawesome-free-5.0.9/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="/backend/css/style.css">
    <link rel="stylesheet" href="/backend/css/nprogress.css">
    @yield('style')
</head>

<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin" layui-layout="{{ session('menu_status','open') }}">
    <div class="layui-header">
        <div class="layui-logo">
            <span>{{ env('APP_NAME') }} 管理系统</span>
        </div>
        <!-- 头部区域 -->
        <ul class="layui-nav layui-layout-left">
            <li class="layui-nav-item layadmin-flexible" lay-unselect>
                <a href="{{ route('flexible') }}" class="ajax-flexible" title="侧边伸缩">
                    <i class="layui-icon layui-icon-shrink-right"></i>
                </a>
            </li>
            <li class="layui-nav-item" lay-unselect>
                <a href="javascript:;" id="refresh" title="刷新数据">
                    <i class="layui-icon layui-icon-refresh"></i>
                </a>
            </li>
            @role('super admin')
            <li class="layui-nav-item" lay-unselect>
                <a href="{{route('flush')}}" class="ajax-post" title="清空缓存">
                    <i class="fa fa-magic"></i>
                </a>
            </li>
            @endrole
        </ul>
        <ul class="layui-nav  layui-layout-right">
            <li class="layui-nav-item" lay-unselect="">
                <a lay-href="app/message/" layadmin-event="message">
                    <i class="layui-icon layui-icon-notice"></i>
                    <span class="layui-badge-dot"></span>
                </a>
            </li>
            <li class="layui-nav-item" lay-unselect>
                <a href="javascript:;" class="user"><img src="{{ asset(Auth::user()->face) }}" class="layui-nav-img">{{ Auth::user()->nickname }} <i class="layui-icon layui-icon-more-vertical"></i></a>
                <dl class="layui-nav-child">
                    <dd><a href="{{ route('me') }}"><i class="fa  fa-user"></i> 个人信息</a></dd>
                    <hr>
                    <dd><a href="{{ route('logout') }}"><i class="fa fa-sign-out"></i> 退出</a></dd>
                </dl>
            </li>
        </ul>
    </div>
    @php $__NAV__ = Auth::user()->getNav();@endphp
    <div class="aside">
        <div class="aside-scroll">
            <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
            <ul class="aside-nav">
                <li class="title">导航菜单</li>
                @isset($__NAV__['menu']) @foreach($__NAV__['menu'] as $vo) @php parse_str($vo['param'],$param);@endphp
                <li>
                    <a href="{{ route($vo['name'],$param) }}" @if (in_array($vo[ 'id'],$__NAV__[ 'parent_ids'])) class="active" @endif>
                        <i class="{{ $vo['icon'] }} fa-fw"></i> {{ $vo['title'] }}
                        <span>@isset($vo['_child'])<i class="fa fa-angle-left"></i>@endisset</span>
                    </a> 
                    @isset($vo['_child'])
                    <dl @if (in_array($vo[ 'id'],$__NAV__[ 'parent_ids'])) style="display: block;" @endif>
                        @foreach($vo['_child'] as $v) @php parse_str($v['param'],$param);@endphp
                        <dd><a href="{{ route($v['name'],$param) }}" @if (in_array($v[ 'id'],$__NAV__[ 'parent_ids'])) class="active" @endif><i class="{{ $v['icon'] }} fa-fw"></i> {{ $v['title']}}</a></dd>
                        @endforeach
                    </dl>
                    @endisset
                </li>
                @endforeach @endisset @role('super admin')
                <li class="title">开发者中心</li>
                <li><a href=""><i class="fa fa-code"></i> 缓存管理</a></li>
                @endrole
            </ul>
        </div>
    </div>
    <div class="main">
        <div class="main-header">
            <div class="layui-breadcrumb">
                <a href="{{ route('/') }}"><i class="fas fa-home fa-fw"></i> 主页</a> 
                @if ($__NAV__['crumb']) 
                    @foreach($__NAV__['crumb'] as $vo) 
                        @php parse_str($vo['param'],$param);@endphp
                        <a href="{{ route($vo['name'],$param) }}"><i class="{{ $vo['icon'] }} fa-fw"></i> {{ $vo['title'] }}</a> 
                    @endforeach
                @endif
                <a href="{{ url()->current() }}"><cite><i class="{{ $__NAV__['self']['icon'] }} fa-fw"></i> {{$__NAV__['self']['title']}}</cite></a>
            </div>
        </div>
        <div class="main-content">
            <div class="layui-fluid" style="padding: 0 12px;">
                <div class="layui-card">
                    <div class="layui-card-header">
                        <i class="{{ $__NAV__['self']['icon'] }} fa-fw"></i> {{ $__NAV__['self']['title'] }}
                        <!-- 放置操作按钮 -->
                        <div class="layui-inline action-btn">
                            @yield('action-btn')
                        </div>
                    </div>
                    <div class="layui-card-body">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
        <div class="main-footer">
            <!-- 底部固定区域 -->
            Copyright © 2016-{{ date('Y') }} 基于 LeaCMF 后台管理系统. All rights reserved.
        </div>
    </div>
</div>
<script src="/backend/js/jquery.min.js"></script>
<script src="/backend/js/nprogress.js"></script>
<script type="text/javascript" src="/backend/layui/layui.js"></script>
<script type="text/javascript">
    layui.config({
        base: '/backend/js/'
    }).use('lea');
</script>
@yield('script')
</body>

</html>