<?php
    // Home
    Breadcrumbs::register('index', function($breadcrumbs)
    {
        $breadcrumbs->push('Home', route('index'));
    });
    // Home > Tin tuc
    Breadcrumbs::register('tintuc', function($breadcrumbs)
    {
        $breadcrumbs->parent('index');
        $breadcrumbs->push('Event', route('tin-tuc'));
    });
    // Home > Cart
    Breadcrumbs::register('cart', function($breadcrumbs)
    {
        $breadcrumbs->parent('index');
        $breadcrumbs->push('Add To Cart', route('cart'));
    });
    // Home > Shop
    Breadcrumbs::register('shop', function($breadcrumbs)
    {
        $breadcrumbs->parent('index');
        $breadcrumbs->push('Shop', route('cua-hang'));
    });
// Home > Page
    Breadcrumbs::register('page.index', function($breadcrumbs,$pages)
    {
        $breadcrumbs->parent('index');
        $breadcrumbs->push($pages->title,route('category.list',$pages->slug));
    });


    // Home > tin tuc> the loai
    Breadcrumbs::register('tintuc.category', function($breadcrumbs,$categories)
    {
        $breadcrumbs->parent('index');
        $breadcrumbs->push($categories->categoryName,route('category.list',$categories->categorySlug));
    });

    //Sản Phẩm Mới
    Breadcrumbs::register('newitem', function($breadcrumbs)
    {
        $breadcrumbs->parent('index');
        $breadcrumbs->push('New', route('newitems'));
    });

    //Brand
    Breadcrumbs::register('brand', function($breadcrumbs)
    {
        $breadcrumbs->parent('index');
        $breadcrumbs->push('Thương hiệu', route('brandindex'));
    });

    //Brand Detail
    Breadcrumbs::register('brand.detail', function($breadcrumbs, $detail_brand)
    {
        $breadcrumbs->parent('index');
        $breadcrumbs->push('Thương hiệu', route('brandindex'));
        $breadcrumbs->push($detail_brand->brandName, route('brand.list', array($detail_brand->brandSlug) ));
    });

    //HotDeal
    Breadcrumbs::register('hotdeal', function($breadcrumbs)
    {
        $breadcrumbs->parent('index');
        $breadcrumbs->push('Hot Deal', route('hotdealitems'));
    });

    //Search
    Breadcrumbs::register('theme.search', function($breadcrumbs)
    {
        $breadcrumbs->parent('index');
        $breadcrumbs->push('Tìm Kiếm', route('theme.search'));
    });

    //Customer Register
    Breadcrumbs::register('customer.register', function($breadcrumbs)
    {
        $breadcrumbs->parent('index');
        $breadcrumbs->push('Đăng ký thành viên', route('registerCustomer'));
    });

    // Home > tin tuc> details
    Breadcrumbs::register('tintuc.details', function($breadcrumbs,$categories,$data_customers)
    {
        $breadcrumbs->parent('index');
        //$breadcrumbs->push('Tin tức', route('tin-tuc'));
        $breadcrumbs->push($categories->categoryName,route('category.list',$categories->categorySlug));
        $breadcrumbs->push($data_customers->title,route('tintuc.details',array($categories->categorySlug,$data_customers->slug)));
    });

    // Home > page
    Breadcrumbs::register('default.page', function($breadcrumbs,$data_customers)
    {
        $breadcrumbs->parent('index');
        //$breadcrumbs->push('Tin tức', route('tin-tuc'));
        $breadcrumbs->push($data_customers->title,route('default.page',$data_customers->slug));
    });
    // Home > tim kiếm
    Breadcrumbs::register('search.doanhnghiep', function($breadcrumbs,$taxcode)
    {
        $breadcrumbs->parent('index');
        $breadcrumbs->push('Search', '#');
        $breadcrumbs->push('Search Keyword: '.$taxcode); 
    });
?>