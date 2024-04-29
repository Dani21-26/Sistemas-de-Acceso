<!DOCTYPE html>
<head>
    <?php include('./container/Link.php')?>
    <title>Login</title>
</head>

<body class="bg-gradient-to-r from-purple-400 to-pink-500  min-h-screen flex items-center justify-center">
    <div class="text-center text-white mx-4 md:mx-8 lg:mx-20">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4  animate__animated animate__fadeInDown">
            Bienvenido Admin
        </h1>
        <p class="text-base md:text-lg lg:text-xl  mb-6 animate__animated animate__fadeInDown">
            Tu plataforma para administrar tu Control de Acceso al personal de trabajo.
        </p>
        <button id="loginBtn" class="bg-white text-purple-500 py-2 px-6 rounded-full font-bold text-lg  hover:underline focus:outline-none focus:shadow-outline transform hover:scale-105 transition  duration-300 animate__animated animate__fadeInUp">
            Login
        </button>
    </div>
    <div id="loginModal" class="hidden fixed top-0 left-0 w-full  h-full bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-8 w-full  max-w-md animate__animated animate__fadeIn">
            <div class="flex justify-end">
                <button id="closeBtn" class="text-gray-800 text-xl">
                    &times;
                </button>
            </div>
            <h2 class="text-xl md:text-2xl lg:text-3xl  font-bold mb-4 text-center text-gray-800">
                Login
            </h2>
            <form id="loginForm" class="space-y-4">
                <div>
                    <label for="username" class="block text-gray-700 text-sm  md:text-base lg:text-lg font-bold mb-2">
                        Username
                    </label>
                    <input class="appearance-none border rounded 
                        w-full py-2 px-3 leading-tight focus:outline-none 
                        focus:shadow-outline"
                        id="username" type="text" 
                        placeholder="Enter your username">
                    <p id="usernameError" class="text-red-500 text-sm"></p>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm md:text-base 
                        lg:text-lg font-bold mb-2" for="password">
                        Password
                    </label>
                    <div class="relative">
                        <input class="appearance-none border rounded w-full 
                            py-2 px-3 leading-tight focus:outline-none 
                            focus:shadow-outline"
                            id="password" type="password" 
                            placeholder="Enter your password">
                        <button id="togglePassword" class="absolute top-0 right-0 
                            mt-3 mr-4 text-gray-700 cursor-pointer 
                            focus:outline-none"
                            type="button">
                            <i id="eyeIcon" class="far fa-eye"></i>
                        </button>
                    </div>
                    <p id="passwordError" class="text-red-500 text-sm"></p>
                </div>
                <button type="button" id="loginSubmit" class="bg-gradient-to-r 
                    from-pink-500 to-purple-500 text-white py-2 px-4 
                    rounded-full focus:outline-none focus:shadow-outline 
                    transform hover:scale-105 transition duration-300">
                    Login
                </button>
            </form>
            <div class="text-center mt-4">
                <a href="#" id="forgotPasswordLink" class="text-purple-500 text-sm  md:text-base lg:text-lg font-bold hover:underline">
                    Forgot your password?
                </a>
                <p id="forgotPasswordError" class="text-red-500 text-sm"></p>
            </div>
        </div>
    </div>
    <div id="forgotPasswordModal" class="hidden fixed top-0 left-0 w-full h-full  bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-8 w-full max-w-md  animate__animated animate__fadeIn">
            <div class="flex justify-end">
                <button id="closeForgotPasswordBtn"  class="text-gray-800 text-xl">
                    &times;
                </button>
            </div>
            <h2 class="text-xl md:text-2xl lg:text-3xl font-bold  mb-4 text-center text-gray-800">
                Forgot Password
            </h2>
            <form id="forgotPasswordForm" class="space-y-4">
                <div>
                    <label class="block text-gray-700 text-sm md:text-base lg:text-lg font-bold mb-2" for="email">
                        Email
                    </label>
                    <input
                        class="appearance-none border rounded w-full 
                        py-2 px-3 leading-tight focus:outline-none 
                        focus:shadow-outline" id="email" 
                        type="email" placeholder="Enter your email">
                    <p id="emailError" class="text-red-500 text-sm"></p>
                </div>
                <button type="button" id="forgotPasswordSubmit"
                    class="bg-gradient-to-r from-pink-500 to-purple-500 
                    text-white py-2 px-4 rounded-full focus:outline-none 
                    focus:shadow-outline transform hover:scale-105 
                    transition duration-300">
                    Submit
                </button>
            </form>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="./JS/index.js"></script>
</body>

</html>