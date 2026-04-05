<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #1C1107; color: #FDF5E6; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background-color: rgba(0,0,0,0.4); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 30px; }
        .logo { font-size: 24px; font-weight: bold; color: #8B4513; margin-bottom: 20px; text-align: center; }
        .title { font-size: 22px; font-weight: bold; margin-bottom: 10px; text-align: center; }
        .description { line-height: 1.6; color: #D1D5DB; margin-bottom: 25px; }
        .button { display: inline-block; background-color: #8B4513; color: white; text-decoration: none; padding: 12px 24px; border-radius: 6px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">Elm Grove Liquor Store</div>
        <div class="title">New Arrival!</div>
        <h3 style="color: #ffffff;">{{ $product->name }}</h3>
        <p class="description">{{ $product->description }}</p>
        <div style="text-align: center; margin-top: 30px;">
            <a href="{{ url('/products/' . $product->slug) }}" class="button">Shop Now</a>
        </div>
    </div>
</body>
</html>
