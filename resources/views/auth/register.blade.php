<!doctype html>
<html lang="en">
<head>
    <title>Register</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/login_regis.css') }}">
</head>
<body>
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-10">
                    <div class="wrap d-md-flex">
                        <div class="text-wrap p-4 p-lg-5 text-center d-flex align-items-center order-md-last">
                            <div class="text w-100">
                                <h2>Welcome to Register</h2>
                                <p>Already have an account?</p>
                                <a href="{{ route('login') }}" class="btn btn-white btn-outline-white">Sign In</a>
                            </div>
                        </div>
                        <div class="login-wrap p-4 p-lg-5">
                            <div class="d-flex">
                                <div class="w-100">
                                    <h3 class="mb-4">Sign Up</h3>
                                </div>
                            </div>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                
                                <div class="flex flex-wrap -mx-2">
                                    <!-- First Name -->
                                    <div class="w-1/2 px-2">
                                        <x-input-label for="name_n" :value="__('First Name')" />
                                        <x-text-input id="name_n" class="block mt-1 w-full form-control" type="text" name="name_n" :value="old('name_n')" required autofocus autocomplete="name_n" />
                                        <x-input-error :messages="$errors->get('name_n')" class="mt-2" />
                                    </div>
                                    
                                    <!-- Last Name -->
                                    <div class="w-1/2 px-2">
                                        <x-input-label for="name_s" :value="__('Last Name')" />
                                        <x-text-input id="name_s" class="block mt-1 w-full form-control" type="text" name="name_s" :value="old('name_s')" required autocomplete="name_s" />
                                        <x-input-error :messages="$errors->get('name_s')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <x-input-label for="username" :value="__('Username')" />
                                    <x-text-input id="username" class="block mt-1 w-full form-control" type="text" name="username" :value="old('username')" required autocomplete="username" />
                                    <x-input-error :messages="$errors->get('username')" class="mt-2" />
                                </div>

                                <div class="flex flex-wrap -mx-2 mt-4">
                                    <!-- Email Address -->
                                    <div class="w-1/2 px-2">
                                        <x-input-label for="email" :value="__('Email')" />
                                        <x-text-input id="email" class="block mt-1 w-full form-control" type="email" name="email" :value="old('email')" required autocomplete="email" />
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>

                                    <!-- Phone -->
                                    <div class="w-1/2 px-2">
                                        <x-input-label for="phone" :value="__('Phone')" />
                                        <x-text-input id="phone" class="block mt-1 w-full form-control" type="text" name="phone" :value="old('phone')" required />
                                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <x-input-label for="gender" :value="__('Gender')" />
                                    <select id="gender" class="block mt-1 w-full form-control" name="gender" required>
                                        <option value="" disabled selected>Select Gender</option>
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                                </div>

                                <div class="flex flex-wrap -mx-2 mt-4">
                                    <!-- Password -->
                                    <div class="w-1/2 px-2">
                                        <x-input-label for="password" :value="__('Password')" />
                                        <x-text-input id="password" class="block mt-1 w-full form-control" type="password" name="password" required autocomplete="new-password" />
                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                    </div>

                                    <!-- Confirm Password -->
                                    <div class="w-1/2 px-2">
                                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                                        <x-text-input id="password_confirmation" class="block mt-1 w-full form-control" type="password" name="password_confirmation" required autocomplete="new-password" />
                                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <button type="submit" class="form-control btn btn-primary submit px-3">
                                        Register
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
