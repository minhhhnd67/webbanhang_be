<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4">
        <div class="flex justify-center">
            <div class="w-full max-w-md">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center text-2xl font-bold">Đăng nhập</h2>
                    </div>
                    <div class="card-body">
                        <form action="/login" method="post">
                            @csrf
                            <div class="mb-4">
                                <label for="email" class="block text-gray-700">Địa chỉ email</label>
                                <input type="email" id="email" name="email" class="form-control w-full" placeholder="Địa chỉ email">
                                @error('email')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="password" class="block text-gray-700">Mật khẩu</label>
                                <input type="password" id="password" name="password" class="form-control w-full" placeholder="Mật khẩu">
                                @error('password')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <input type="checkbox" name="remember" id="remember">
                                <label for="remember" class="text-gray-700">Nhớ đăng nhập</label>
                            </div>
                            <div class="flex justify-center">
                                <button type="submit" class="btn btn-primary w-full">Đăng nhập</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <p class="text-center text-gray-700">Chưa có tài khoản? <a href="/register">Đăng ký</a></p>
                    </div>
                    <hr>
                        <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <a href="{{ url('/auth/redirect/facebook') }}" class="btn btn-primary"><i class="fa fa-facebook"></i> Facebook</a>
                        </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>