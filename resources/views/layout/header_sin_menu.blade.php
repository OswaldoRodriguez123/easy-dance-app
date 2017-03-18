<header id="header" class="clearfix" data-current-skin="orange">
    <ul class="header-inner">
        <li class="logo hidden-xs" popover-placement="bottom" popover-trigger="mouseenter" popover="Inicio">
            <a data-ui-sref="home" href="{{ empty(Auth::check()) ? 'http://easydancelatino.com/' : '/inicio'}}"data-ng-click="edctrl.sidebarStat($event)"><!--Easy Dance--> <img src="{{url('/')}}/assets/img/logo.png" class="img-opaco p-b-0 m-b-0 p-r-0 m-r-0" width="90">
            <sub class="beta text-capitalize f-12 text-right">beta</sub>
            </a>
        </li>
    </ul>
</header>