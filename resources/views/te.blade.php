@extends('layouts.default')
@section('content')


<div class="main_menu_area">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12 col-md-12">
                <div class="main_menu menu_position">
                    <nav>
                        <ul class="submenu">
                            @foreach($categories as $cat)
                                <li class="{{ count($cat->districts) > 0 ? 'mega_items' : ''}}" style=""><a href="#">{{ $cat->division_name_en }}</a> 
                                    @if ($cat->districts)
                                        <ul style="">
                                            @foreach ($cat->districts as $sub_category)
                                            <li><a href="">{{ $sub_category->district_name_en }}</a><br> @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>

                        <ul>
                            <li><a class="active" href="https://www.igloobd.com">home</a></li>
                            <li class="mega_items">
                                <a class="" href="https://www.igloobd.com/products">products<i class="fa fa-angle-down"></i></a>
                                <div class="mega_menu">
                                    <ul class="mega_menu_inner">
                                        <li>
                                            <a href="#">Stick</a>
                                            <ul>
                                                <li><a href="https://www.igloobd.com/products?subCategory=regular">Regular</a></li>
                                                <li><a href="https://www.igloobd.com/products?subCategory=premium">Premium</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="#">Cup</a>
                                            <ul>
                                                <li><a href="https://www.igloobd.com/products?subCategory=regular-1">Regular</a></li>
                                                <li><a href="https://www.igloobd.com/products?subCategory=premium-1">Premium</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="#">Cone</a>
                                            <ul>
                                                <li><a href="https://www.igloobd.com/products?subCategory=cone">Cone</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="#">Family</a>
                                            <ul>
                                                <li><a href="https://www.igloobd.com/products?subCategory=regular-2">Regular</a></li>
                                                <li><a href="https://www.igloobd.com/products?subCategory=value-added">Value Added</a></li>
                                                <li><a href="https://www.igloobd.com/products?subCategory=dessert">Dessert</a></li>
                                                <li><a href="https://www.igloobd.com/products?subCategory=double-sundae">Double Sundae</a></li>
                                                <li><a href="https://www.igloobd.com/products?subCategory=gold">Gold</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="#">Cake</a>
                                            <ul>
                                                <li><a href="https://www.igloobd.com/products?subCategory=cake">Cake</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="#">5 Liter</a>
                                            <ul>
                                                <li><a href="https://www.igloobd.com/products?subCategory=celebrations-5-liter">Celebrations 5 Liter</a></li>
                                                <li><a href="https://www.igloobd.com/products?subCategory=5-liter-regular">5 Liter Regular</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="#">Frozen products</a>
                                            <ul>
                                                <li><a href="https://www.igloobd.com/products?subCategory=frozen-products">Frozen products</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="#">Dairy products</a>
                                            <ul>
                                                <li><a href="https://www.igloobd.com/products?subCategory=dairy-products">Dairy products</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="#">Sandwich</a>
                                            <ul>
                                                <li><a href="https://www.igloobd.com/products?subCategory=sandwich">Sandwich</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="#">2 Liter</a>
                                            <ul>
                                                <li><a href="https://www.igloobd.com/products?subCategory=5-liter-celebration">Regular</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li><a href="#">Flavors<i class="fa fa-angle-down"></i></a>
                                <ul class="sub_menu pages">
                                    <li>
                                        <a href="https://www.igloobd.com/products?flavor=chocolate">Chocolate</a>
                                    </li>
                                    <li>
                                        <a href="https://www.igloobd.com/products?flavor=strawberry">Strawberry</a>
                                    </li>
                                    <li>
                                        <a href="https://www.igloobd.com/products?flavor=vanilla">Vanilla</a>
                                    </li>
                                    <li>
                                        <a href="https://www.igloobd.com/products?flavor=mango">Mango</a>
                                    </li>
                                    <li>
                                        <a href="https://www.igloobd.com/products?flavor=blueberry">Blueberry</a>
                                    </li>
                                    <li>
                                        <a href="https://www.igloobd.com/products?flavor=orange">Orange</a>
                                    </li>
                                    <li>
                                        <a href="https://www.igloobd.com/products?flavor=yogurt">Yogurt</a>
                                    </li>
                                    <li>
                                        <a href="https://www.igloobd.com/products?flavor=banana">Banana</a>
                                    </li>
                                    <li>
                                        <a href="https://www.igloobd.com/products?flavor=lemon">Lemon</a>
                                    </li>
                                    <li>
                                        <a href="https://www.igloobd.com/products?flavor=malai">Malai</a>
                                    </li>
                                    <li>
                                        <a href="https://www.igloobd.com/products?flavor=coffee">Coffee</a>
                                    </li>
                                    <li>
                                        <a href="https://www.igloobd.com/products?flavor=malted">Malted</a>
                                    </li>
                                    <li>
                                        <a href="https://www.igloobd.com/products?flavor=butter-scotch">Butter Scotch</a>
                                    </li>
                                    <li>
                                        <a href="https://www.igloobd.com/products?flavor=ambrosia">Ambrosia</a>
                                    </li>
                                    <li>
                                        <a href="https://www.igloobd.com/products?flavor=deshi-dessert">Deshi Dessert</a>
                                    </li>
                                    <li>
                                        <a href="https://www.igloobd.com/products?flavor=red-velvet">Red Velvet</a>
                                    </li>
                                    <li class="sub_menu_parent"><a>Dual Flavor</a>
                                        <ul class="sub_menu sub_menu_child">
                                            <a href="https://www.igloobd.com/products?flavor=vanilla-%26-chocolate">Vanilla &amp; Chocolate</a>
                                            <a href="https://www.igloobd.com/products?flavor=vanilla-%26-strawberry">Vanilla &amp; Strawberry</a>
                                            <a href="https://www.igloobd.com/products?flavor=chocolate-%26-pistachio">Chocolate &amp; Pistachio</a>
                                            <a href="https://www.igloobd.com/products?flavor=chocolate-%26-cookies">Chocolate &amp; Cookies</a>
                                            <a href="https://www.igloobd.com/products?flavor=vanilla-%26-mango">Vanilla &amp; Mango</a>
                                            <a href="https://www.igloobd.com/products?flavor=vanilla-%26-caramel">Vanilla &amp; Caramel</a>
                                            <a href="https://www.igloobd.com/products?flavor=mango-%26-chocolate">Mango &amp; Chocolate</a>
                                            <a href="https://www.igloobd.com/products?flavor=cheese">Cheese</a>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li><a href="https://www.igloobd.com/my-offer">offers</a></li>
                            <li><a href="https://www.igloobd.com/igloo-gallery">gallery</a></li>
                            <li><a>blog<i class="fa fa-angle-down"></i></a>
                                <ul class="sub_menu pages">
                                    <li><a href="https://www.igloobd.com/igloo-recipe">Recipe</a></li>
                                    <li><a href="https://www.igloobd.com/igloo-article">Article</a></li>
                                </ul>
                            </li>
                            <li><a href="https://www.igloobd.com/igloo-order-process">Order Process</a></li>
                            <li><a href="https://www.igloobd.com/about-us">About US</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection