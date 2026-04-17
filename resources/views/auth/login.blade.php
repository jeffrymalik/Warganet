<!doctype html>
<html
  lang="en"
  x-data="{ darkMode: false }"
  x-init="
    darkMode = JSON.parse(localStorage.getItem('darkMode') ?? 'false');
    $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))
  "
  :class="darkMode ? 'dark' : ''"
>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login | Sistem Kelola RT</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  </head>
  <body class="bg-gray-50 dark:bg-boxdark-2">

    <div class="flex min-h-screen items-center justify-center">
      <div class="w-full max-w-md rounded-2xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-boxdark p-8 shadow-lg">

        {{-- Logo & Title --}}
        <div class="mb-8 text-center">
          <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
            Sistem Kelola RT
          </h1>
          <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
            Silakan login untuk melanjutkan
          </p>
        </div>

        {{-- Error Message --}}
        @if ($errors->any())
          <div class="mb-4 rounded-lg bg-red-50 dark:bg-red-900/20 p-4">
            <p class="text-sm text-red-600 dark:text-red-400">
              {{ $errors->first() }}
            </p>
          </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('login') }}">
          @csrf

          {{-- Email --}}
          <div class="mb-4">
            <label
              for="email"
              class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
            >
              Email
            </label>
            <input
              type="email"
              id="email"
              name="email"
              value="{{ old('email') }}"
              placeholder="contoh@email.com"
              required
              class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-boxdark-2 px-4 py-3 text-sm text-gray-800 dark:text-white placeholder:text-gray-400 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/20"
            />
          </div>

          {{-- Password --}}
          <div class="mb-6">
            <label
              for="password"
              class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
            >
              Password
            </label>
            <div class="relative" x-data="{ showPassword: false }">
              <input
                :type="showPassword ? 'text' : 'password'"
                id="password"
                name="password"
                placeholder="Masukkan password"
                required
                class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-boxdark-2 px-4 py-3 text-sm text-gray-800 dark:text-white placeholder:text-gray-400 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/20"
              />
              {{-- Toggle show/hide password --}}
              <button
                type="button"
                @click="showPassword = !showPassword"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
              >
                <svg x-show="!showPassword" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M12 5C7.18879 5 3.07991 8.02661 1.28767 12.3328C1.17028 12.6154 1.17028 12.9321 1.28767 13.2147C3.07991 17.5209 7.18879 20.5475 12 20.5475C16.8112 20.5475 20.9201 17.5209 22.7123 13.2147C22.8297 12.9321 22.8297 12.6154 22.7123 12.3328C20.9201 8.02661 16.8112 5 12 5ZM12 17.7737C9.11239 17.7737 6.77246 15.4338 6.77246 12.5462C6.77246 9.65853 9.11239 7.3186 12 7.3186C14.8876 7.3186 17.2275 9.65853 17.2275 12.5462C17.2275 15.4338 14.8876 17.7737 12 17.7737ZM12 9.63721C10.3928 9.63721 9.09107 10.939 9.09107 12.5462C9.09107 14.1534 10.3928 15.4551 12 15.4551C13.6072 15.4551 14.9089 14.1534 14.9089 12.5462C14.9089 10.939 13.6072 9.63721 12 9.63721Z" fill="currentColor"/>
                </svg>
                <svg x-show="showPassword" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M3.70711 2.29289C3.31658 1.90237 2.68342 1.90237 2.29289 2.29289C1.90237 2.68342 1.90237 3.31658 2.29289 3.70711L6.27177 7.68599C3.89893 9.35868 2.10072 11.8662 1.28767 14.8328C1.17028 15.1154 1.17028 15.4321 1.28767 15.7147C3.07991 20.0209 7.18879 23.0475 12 23.0475C14.1885 23.0475 16.2218 22.3884 17.9116 21.2568L20.2929 23.7071C20.6834 24.0976 21.3166 24.0976 21.7071 23.7071C22.0976 23.3166 22.0976 22.6834 21.7071 22.2929L3.70711 2.29289ZM12 20.2737C8.50628 20.2737 5.51066 18.1209 4.07107 15.0462C4.87604 12.8452 6.4424 11.0277 8.44888 9.86307L10.1765 11.5907C9.77018 12.1552 9.52734 12.8437 9.52734 13.5924C9.52734 15.4866 11.0712 17.0305 12.9653 17.0305C13.714 17.0305 14.4025 16.7877 14.967 16.3814L16.4704 17.8848C15.2011 18.7738 13.6614 19.2975 12 19.2975V20.2737Z" fill="currentColor"/>
                </svg>
              </button>
            </div>
          </div>

          {{-- Submit Button --}}
          <button
            type="submit"
            class="w-full rounded-lg bg-brand-500 px-4 py-3 text-sm font-semibold text-white hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-500/20 transition-colors"
          >
            Login
          </button>
        </form>

      </div>
    </div>

    <script type="module" src="{{ asset('js/bundle.js') }}"></script>
  </body>
</html>