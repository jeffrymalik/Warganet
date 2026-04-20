<aside
  :class="sidebarToggle ? 'translate-x-0 lg:w-[90px]' : '-translate-x-full'"
  class="sidebar fixed left-0 top-0 z-9999 flex h-screen w-[290px] flex-col overflow-y-hidden border-r border-gray-200 bg-white px-5 dark:border-gray-800 dark:bg-black lg:static lg:translate-x-0"
>
  <!-- SIDEBAR HEADER -->
  <div
    :class="sidebarToggle ? 'justify-center' : 'justify-between'"
    class="flex items-center gap-2 pt-8 sidebar-header pb-7"
  >
    <a href="#" class="flex justify-center w-full">
      <span class="logo" :class="sidebarToggle ? 'hidden' : ''">
        <img width="150" class="dark:hidden mx-auto" src="{{ asset('/images/logo/logo-dark.png') }}" alt="Logo" />
        <img width="150" class="hidden dark:block mx-auto" src="{{ asset('/images/logo/logo.png') }}" alt="Logo" />
      </span>

      <img
        class="logo-icon mx-auto"
        :class="sidebarToggle ? 'lg:block' : 'hidden'"
        src="{{ asset('/images/logo/logo-icon.png') }}"
        alt="Logo"
      />
    </a>
  </div>
  <!-- SIDEBAR HEADER -->

  <div class="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar">
    <!-- Sidebar Menu -->
    <nav x-data="{selected: $persist('Dashboard')}">

      <!-- ===================== -->
      <!-- MENU GROUP: UTAMA     -->
      <!-- ===================== -->
      <div>
        <h3 class="mb-4 text-xs uppercase leading-[20px] text-gray-400">
          <span class="menu-group-title" :class="sidebarToggle ? 'lg:hidden' : ''">Menu Utama</span>
          <svg
            :class="sidebarToggle ? 'lg:block hidden' : 'hidden'"
            class="mx-auto fill-current menu-group-icon"
            width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
          >
            <path fill-rule="evenodd" clip-rule="evenodd" d="M5.99915 10.2451C6.96564 10.2451 7.74915 11.0286 7.74915 11.9951V12.0051C7.74915 12.9716 6.96564 13.7551 5.99915 13.7551C5.03265 13.7551 4.24915 12.9716 4.24915 12.0051V11.9951C4.24915 11.0286 5.03265 10.2451 5.99915 10.2451ZM17.9991 10.2451C18.9656 10.2451 19.7491 11.0286 19.7491 11.9951V12.0051C19.7491 12.9716 18.9656 13.7551 17.9991 13.7551C17.0326 13.7551 16.2491 12.9716 16.2491 12.0051V11.9951C16.2491 11.0286 17.0326 10.2451 17.9991 10.2451ZM13.7491 11.9951C13.7491 11.0286 12.9656 10.2451 11.9991 10.2451C11.0326 10.2451 10.2491 11.0286 10.2491 11.9951V12.0051C10.2491 12.9716 11.0326 13.7551 11.9991 13.7551C12.9656 13.7551 13.7491 12.9716 13.7491 12.0051V11.9951Z" fill="" />
          </svg>
        </h3>

        <ul class="flex flex-col gap-4 mb-6">

          {{-- ==================== --}}
          {{-- MENU ITEM: DASHBOARD --}}
          {{-- ==================== --}}
          <li>
            <a
              href="#"
              class="menu-item group"
              :class="(selected === 'Dashboard') || (page === 'dashboard') ? 'menu-item-active' : 'menu-item-inactive'"
              @click.prevent="selected = (selected === 'Dashboard' ? '' : 'Dashboard')"
            >
              {{-- Icon Dashboard --}}
              <svg
                :class="(selected === 'Dashboard') || (page === 'dashboard') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
                width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
              >
                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.5 3.25C4.25736 3.25 3.25 4.25736 3.25 5.5V8.99998C3.25 10.2426 4.25736 11.25 5.5 11.25H9C10.2426 11.25 11.25 10.2426 11.25 8.99998V5.5C11.25 4.25736 10.2426 3.25 9 3.25H5.5ZM4.75 5.5C4.75 5.08579 5.08579 4.75 5.5 4.75H9C9.41421 4.75 9.75 5.08579 9.75 5.5V8.99998C9.75 9.41419 9.41421 9.74998 9 9.74998H5.5C5.08579 9.74998 4.75 9.41419 4.75 8.99998V5.5ZM5.5 12.75C4.25736 12.75 3.25 13.7574 3.25 15V18.5C3.25 19.7426 4.25736 20.75 5.5 20.75H9C10.2426 20.75 11.25 19.7427 11.25 18.5V15C11.25 13.7574 10.2426 12.75 9 12.75H5.5ZM4.75 15C4.75 14.5858 5.08579 14.25 5.5 14.25H9C9.41421 14.25 9.75 14.5858 9.75 15V18.5C9.75 18.9142 9.41421 19.25 9 19.25H5.5C5.08579 19.25 4.75 18.9142 4.75 18.5V15ZM12.75 5.5C12.75 4.25736 13.7574 3.25 15 3.25H18.5C19.7426 3.25 20.75 4.25736 20.75 5.5V8.99998C20.75 10.2426 19.7426 11.25 18.5 11.25H15C13.7574 11.25 12.75 10.2426 12.75 8.99998V5.5ZM15 4.75C14.5858 4.75 14.25 5.08579 14.25 5.5V8.99998C14.25 9.41419 14.5858 9.74998 15 9.74998H18.5C18.9142 9.74998 19.25 9.41419 19.25 8.99998V5.5C19.25 5.08579 18.9142 4.75 18.5 4.75H15ZM15 12.75C13.7574 12.75 12.75 13.7574 12.75 15V18.5C12.75 19.7426 13.7574 20.75 15 20.75H18.5C19.7426 20.75 20.75 19.7427 20.75 18.5V15C20.75 13.7574 19.7426 12.75 18.5 12.75H15ZM14.25 15C14.25 14.5858 14.5858 14.25 15 14.25H18.5C18.9142 14.25 19.25 14.5858 19.25 15V18.5C19.25 18.9142 18.9142 19.25 18.5 19.25H15C14.5858 19.25 14.25 18.9142 14.25 18.5V15Z" fill="" />
              </svg>
              <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Dashboard</span>
            </a>
          </li>
          {{-- END DASHBOARD --}}

          {{-- ========================== --}}
          {{-- MENU ITEM: NOTIFIKASI      --}}
          {{-- Tampil untuk ADMIN & WARGA --}}
          {{-- ========================== --}}
          
          {{-- <li>
            <a
              href="#"
              class="menu-item group"
              :class="(selected === 'Notifikasi') || (page === 'notifikasi') ? 'menu-item-active' : 'menu-item-inactive'"
              @click.prevent="selected = (selected === 'Notifikasi' ? '' : 'Notifikasi')"
            >
              <svg
                :class="(selected === 'Notifikasi') || (page === 'notifikasi') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
                width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
              >
                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2.75C8.82436 2.75 6.25 5.32436 6.25 8.5V8.7041C6.25 9.30456 6.07732 9.8916 5.75212 10.3979L4.65396 12.1121C3.68872 13.6317 4.48936 15.6648 6.24526 16.0864C6.90919 16.2444 7.57808 16.3717 8.25 16.4679V17C8.25 18.7949 9.70507 20.25 11.5 20.25H12.5C14.2949 20.25 15.75 18.7949 15.75 17V16.4679C16.4219 16.3717 17.0908 16.2444 17.7547 16.0864C19.5106 15.6648 20.3113 13.6317 19.346 12.1121L18.2479 10.3979C17.9227 9.8916 17.75 9.30456 17.75 8.7041V8.5C17.75 5.32436 15.1756 2.75 12 2.75ZM14.25 16.6461C12.7573 16.7506 11.2427 16.7506 9.75 16.6461V17C9.75 17.9665 10.5335 18.75 11.5 18.75H12.5C13.4665 18.75 14.25 17.9665 14.25 17V16.6461ZM7.75 8.5C7.75 6.15279 9.65279 4.25 12 4.25C14.3472 4.25 16.25 6.15279 16.25 8.5V8.7041C16.25 9.59497 16.5066 10.4674 16.9913 11.2133L18.0894 12.9275C18.4951 13.5555 18.1606 14.3957 17.4328 14.5694C13.8425 15.4272 10.1575 15.4272 6.56724 14.5694C5.83936 14.3957 5.50485 13.5555 5.91058 12.9275L7.0087 11.2133C7.49336 10.4674 7.75 9.59497 7.75 8.7041V8.5Z" fill="" />
              </svg>
              <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Notifikasi</span>
            </a>
          </li> --}}

          {{-- END NOTIFIKASI --}}

          {{-- ================================= --}}
          {{-- MENU ITEM: JADWAL & PENGUMUMAN    --}}
          {{-- Tampil untuk ADMIN & WARGA        --}}
          {{-- ================================= --}}
          <li>
            <a
              href="#"
              class="menu-item group"
              :class="(selected === 'Jadwal') || (page === 'jadwal' || page === 'pengumuman') ? 'menu-item-active' : 'menu-item-inactive'"
              @click.prevent="selected = (selected === 'Jadwal' ? '' : 'Jadwal')"
            >
              {{-- Icon Calendar --}}
              <svg
                :class="(selected === 'Jadwal') || (page === 'jadwal' || page === 'pengumuman') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
                width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
              >
                <path fill-rule="evenodd" clip-rule="evenodd" d="M8 2C8.41421 2 8.75 2.33579 8.75 2.75V3.75H15.25V2.75C15.25 2.33579 15.5858 2 16 2C16.4142 2 16.75 2.33579 16.75 2.75V3.75H18.5C19.7426 3.75 20.75 4.75736 20.75 6V9V19C20.75 20.2426 19.7426 21.25 18.5 21.25H5.5C4.25736 21.25 3.25 20.2426 3.25 19V9V6C3.25 4.75736 4.25736 3.75 5.5 3.75H7.25V2.75C7.25 2.33579 7.58579 2 8 2ZM8 5.25H5.5C5.08579 5.25 4.75 5.58579 4.75 6V8.25H19.25V6C19.25 5.58579 18.9142 5.25 18.5 5.25H16H8ZM19.25 9.75H4.75V19C4.75 19.4142 5.08579 19.75 5.5 19.75H18.5C18.9142 19.75 19.25 19.4142 19.25 19V9.75Z" fill="" />
              </svg>
              <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Jadwal & Pengumuman</span>
              <svg
                class="menu-item-arrow absolute right-2.5 top-1/2 -translate-y-1/2 stroke-current"
                :class="[(selected === 'Jadwal') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive', sidebarToggle ? 'lg:hidden' : '']"
                width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"
              >
                <path d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </a>

            <div class="overflow-hidden transform translate" :class="(selected === 'Jadwal') ? 'block' : 'hidden'">
              <ul :class="sidebarToggle ? 'lg:hidden' : 'flex'" class="flex flex-col gap-1 mt-2 menu-dropdown pl-9">
                <li>
                  <a href="#" class="menu-dropdown-item group" :class="page === 'jadwal' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'">
                    Jadwal Kegiatan
                  </a>
                </li>
                <li>
                  <a href="#" class="menu-dropdown-item group" :class="page === 'pengumuman' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'">
                    Pengumuman
                  </a>
                </li>
              </ul>
            </div>
          </li>
          {{-- END JADWAL & PENGUMUMAN --}}

          {{-- ========================= --}}
          {{-- MENU ITEM: KELUHAN WARGA  --}}
          {{-- Tampil untuk ADMIN & WARGA --}}
          {{-- ========================= --}}
          <li>
            <a
              href="#"
              class="menu-item group"
              :class="(selected === 'Keluhan') || (page === 'keluhanSaya' || page === 'keluhanList') ? 'menu-item-active' : 'menu-item-inactive'"
              @click.prevent="selected = (selected === 'Keluhan' ? '' : 'Keluhan')"
            >
              {{-- Icon Chat / Complaint --}}
              <svg
                :class="(selected === 'Keluhan') || (page === 'keluhanSaya' || page === 'keluhanList') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
                width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
              >
                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.25 8C3.25 5.37665 5.37665 3.25 8 3.25H16C18.6234 3.25 20.75 5.37665 20.75 8V14C20.75 16.6234 18.6234 18.75 16 18.75H13.9199L11.3164 21.3535C10.7307 21.9393 9.75 21.5226 9.75 20.6971V18.75H8C5.37665 18.75 3.25 16.6234 3.25 14V8ZM8 4.75C6.20507 4.75 4.75 6.20507 4.75 8V14C4.75 15.7949 6.20507 17.25 8 17.25H10.5C10.9142 17.25 11.25 17.5858 11.25 18V19.6863L13.1836 17.7528C13.3243 17.6121 13.5151 17.5329 13.714 17.5329H16C17.7949 17.5329 19.25 16.0779 19.25 14.2829V8C19.25 6.20507 17.7949 4.75 16 4.75H8ZM8.25 10C8.25 9.58579 8.58579 9.25 9 9.25H15C15.4142 9.25 15.75 9.58579 15.75 10C15.75 10.4142 15.4142 10.75 15 10.75H9C8.58579 10.75 8.25 10.4142 8.25 10ZM9 12.25C8.58579 12.25 8.25 12.5858 8.25 13C8.25 13.4142 8.58579 13.75 9 13.75H12C12.4142 13.75 12.75 13.4142 12.75 13C12.75 12.5858 12.4142 12.25 12 12.25H9Z" fill="" />
              </svg>
              <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Keluhan Warga</span>
              <svg
                class="menu-item-arrow absolute right-2.5 top-1/2 -translate-y-1/2 stroke-current"
                :class="[(selected === 'Keluhan') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive', sidebarToggle ? 'lg:hidden' : '']"
                width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"
              >
                <path d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </a>

            <div class="overflow-hidden transform translate" :class="(selected === 'Keluhan') ? 'block' : 'hidden'">
              <ul :class="sidebarToggle ? 'lg:hidden' : 'flex'" class="flex flex-col gap-1 mt-2 menu-dropdown pl-9">

                @if (auth()->user()->role === 'admin')
                  {{-- Admin: lihat semua keluhan --}}
                  <li>
                    <a href="#" class="menu-dropdown-item group" :class="page === 'keluhanList' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'">
                      Semua Keluhan
                    </a>
                  </li>
                @else
                  {{-- Warga: hanya keluhan milik sendiri --}}
                  <li>
                    <a href="#" class="menu-dropdown-item group" :class="page === 'keluhanSaya' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'">
                      Keluhan Saya
                    </a>
                  </li>
                  <li>
                    <a href="#" class="menu-dropdown-item group" :class="page === 'keluhanBuat' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'">
                      Buat Keluhan
                    </a>
                  </li>
                @endif

              </ul>
            </div>
          </li>
          {{-- END KELUHAN WARGA --}}

          {{-- ========================= --}}
          {{-- MENU ITEM: SURAT MENYURAT --}}
          {{-- Tampil untuk ADMIN & WARGA --}}
          {{-- ========================= --}}
          <li>
            <a
              href="#"
              class="menu-item group"
              :class="(selected === 'Surat') || (page === 'suratAjukan' || page === 'suratList' || page === 'suratKelola') ? 'menu-item-active' : 'menu-item-inactive'"
              @click.prevent="selected = (selected === 'Surat' ? '' : 'Surat')"
            >
              {{-- Icon Document --}}
              <svg
                :class="(selected === 'Surat') || (page === 'suratAjukan' || page === 'suratList' || page === 'suratKelola') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
                width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
              >
                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.50391 4.25C8.50391 3.83579 8.83969 3.5 9.25391 3.5H15.2777C15.4766 3.5 15.6674 3.57902 15.8081 3.71967L18.2807 6.19234C18.4214 6.333 18.5004 6.52376 18.5004 6.72268V16.75C18.5004 17.1642 18.1646 17.5 17.7504 17.5H16.248V17.4993H14.748V17.5H9.25391C8.83969 17.5 8.50391 17.1642 8.50391 16.75V4.25ZM14.748 19H9.25391C8.01126 19 7.00391 17.9926 7.00391 16.75V6.49854H6.24805C5.83383 6.49854 5.49805 6.83432 5.49805 7.24854V19.75C5.49805 20.1642 5.83383 20.5 6.24805 20.5H13.998C14.4123 20.5 14.748 20.1642 14.748 19.75L14.748 19ZM7.00391 4.99854V4.25C7.00391 3.00736 8.01127 2 9.25391 2H15.2777C15.8745 2 16.4468 2.23705 16.8687 2.659L19.3414 5.13168C19.7634 5.55364 20.0004 6.12594 20.0004 6.72268V16.75C20.0004 17.9926 18.9931 19 17.7504 19H16.248L16.248 19.75C16.248 20.9926 15.2407 22 13.998 22H6.24805C5.00541 22 3.99805 20.9926 3.99805 19.75V7.24854C3.99805 6.00589 5.00541 4.99854 6.24805 4.99854H7.00391Z" fill="" />
              </svg>
              <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Layanan Surat</span>
              <svg
                class="menu-item-arrow absolute right-2.5 top-1/2 -translate-y-1/2 stroke-current"
                :class="[(selected === 'Surat') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive', sidebarToggle ? 'lg:hidden' : '']"
                width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"
              >
                <path d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </a>

            <div class="overflow-hidden transform translate" :class="(selected === 'Surat') ? 'block' : 'hidden'">
              <ul :class="sidebarToggle ? 'lg:hidden' : 'flex'" class="flex flex-col gap-1 mt-2 menu-dropdown pl-9">

                @if (auth()->user()->role === 'admin')
                  {{-- Admin: kelola semua permohonan surat --}}
                  <li>
                    <a href="#" class="menu-dropdown-item group" :class="page === 'suratKelola' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'">
                      Kelola Permohonan
                    </a>
                  </li>
                @else
                  {{-- Warga: ajukan & lihat status surat --}}
                  <li>
                    <a href="#" class="menu-dropdown-item group" :class="page === 'suratAjukan' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'">
                      Ajukan Surat
                    </a>
                  </li>
                  <li>
                    <a href="#" class="menu-dropdown-item group" :class="page === 'suratList' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'">
                      Status Permohonan
                    </a>
                  </li>
                @endif

              </ul>
            </div>
          </li>
          {{-- END SURAT MENYURAT --}}

        </ul>
      </div>
      {{-- END MENU GROUP: UTAMA --}}


      {{-- ======================== --}}
      {{-- MENU GROUP: KEUANGAN    --}}
      {{-- Tampil untuk ADMIN & WARGA --}}
      {{-- ======================== --}}
      <div>
        <h3 class="mb-4 text-xs uppercase leading-[20px] text-gray-400">
          <span class="menu-group-title" :class="sidebarToggle ? 'lg:hidden' : ''">Keuangan</span>
          <svg
            :class="sidebarToggle ? 'lg:block hidden' : 'hidden'"
            class="mx-auto fill-current menu-group-icon"
            width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
          >
            <path fill-rule="evenodd" clip-rule="evenodd" d="M5.99915 10.2451C6.96564 10.2451 7.74915 11.0286 7.74915 11.9951V12.0051C7.74915 12.9716 6.96564 13.7551 5.99915 13.7551C5.03265 13.7551 4.24915 12.9716 4.24915 12.0051V11.9951C4.24915 11.0286 5.03265 10.2451 5.99915 10.2451ZM17.9991 10.2451C18.9656 10.2451 19.7491 11.0286 19.7491 11.9951V12.0051C19.7491 12.9716 18.9656 13.7551 17.9991 13.7551C17.0326 13.7551 16.2491 12.9716 16.2491 12.0051V11.9951C16.2491 11.0286 17.0326 10.2451 17.9991 10.2451ZM13.7491 11.9951C13.7491 11.0286 12.9656 10.2451 11.9991 10.2451C11.0326 10.2451 10.2491 11.0286 10.2491 11.9951V12.0051C10.2491 12.9716 11.0326 13.7551 11.9991 13.7551C12.9656 13.7551 13.7491 12.9716 13.7491 12.0051V11.9951Z" fill="" />
          </svg>
        </h3>

        <ul class="flex flex-col gap-4 mb-6">

          {{-- ================ --}}
          {{-- MENU ITEM: IPL   --}}
          {{-- ================ --}}
          <li>
            <a
              href="#"
              class="menu-item group"
              :class="(selected === 'IPL') || (page === 'iplTagihan' || page === 'iplKelola' || page === 'iplRiwayat') ? 'menu-item-active' : 'menu-item-inactive'"
              @click.prevent="selected = (selected === 'IPL' ? '' : 'IPL')"
            >
              {{-- Icon Money / Building --}}
              <svg
                :class="(selected === 'IPL') || (page === 'iplTagihan' || page === 'iplKelola' || page === 'iplRiwayat') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
                width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
              >
                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.3359 2.29289C11.7265 1.90237 12.2735 1.90237 12.6641 2.29289L21.6641 11.2929C22.0546 11.6834 22.0546 12.3166 21.6641 12.7071C21.2736 13.0976 20.6404 13.0976 20.2499 12.7071L20 12.4571V20C20 21.1046 19.1046 22 18 22H6C4.89543 22 4 21.1046 4 20V12.4571L3.75008 12.7071C3.35956 13.0976 2.72639 13.0976 2.33587 12.7071C1.94535 12.3166 1.94535 11.6834 2.33587 11.2929L11.3359 2.29289ZM6 10.4571V20H9V15C9 13.8954 9.89543 13 11 13H13C14.1046 13 15 13.8954 15 15V20H18V10.4571L12 4.45711L6 10.4571ZM13 20V15H11V20H13Z" fill="" />
              </svg>
              <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">IPL (Iuran Pengelolaan)</span>
              <svg
                class="menu-item-arrow absolute right-2.5 top-1/2 -translate-y-1/2 stroke-current"
                :class="[(selected === 'IPL') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive', sidebarToggle ? 'lg:hidden' : '']"
                width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"
              >
                <path d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </a>

            <div class="overflow-hidden transform translate" :class="(selected === 'IPL') ? 'block' : 'hidden'">
              <ul :class="sidebarToggle ? 'lg:hidden' : 'flex'" class="flex flex-col gap-1 mt-2 menu-dropdown pl-9">

                @if (auth()->user()->role === 'admin')
                  <li>
                    <a href="#" class="menu-dropdown-item group" :class="page === 'iplKelola' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'">
                      Kelola IPL
                    </a>
                  </li>
                  <li>
                    <a href="#" class="menu-dropdown-item group" :class="page === 'iplRiwayat' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'">
                      Riwayat Pembayaran
                    </a>
                  </li>
                @else
                  <li>
                    <a href="#" class="menu-dropdown-item group" :class="page === 'iplTagihan' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'">
                      Tagihan IPL Saya
                    </a>
                  </li>
                  <li>
                    <a href="#" class="menu-dropdown-item group" :class="page === 'iplRiwayat' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'">
                      Riwayat Bayar
                    </a>
                  </li>
                @endif

              </ul>
            </div>
          </li>
          {{-- END IPL --}}

          {{-- ================== --}}
          {{-- MENU ITEM: IURAN   --}}
          {{-- ================== --}}
          <li>
            <a
              href="#"
              class="menu-item group"
              :class="(selected === 'Iuran') || (page === 'iuranTagihan' || page === 'iuranKelola' || page === 'iuranRiwayat') ? 'menu-item-active' : 'menu-item-inactive'"
              @click.prevent="selected = (selected === 'Iuran' ? '' : 'Iuran')"
            >
              {{-- Icon Wallet --}}
              <svg
                :class="(selected === 'Iuran') || (page === 'iuranTagihan' || page === 'iuranKelola' || page === 'iuranRiwayat') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
                width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
              >
                <path fill-rule="evenodd" clip-rule="evenodd" d="M2.75 7C2.75 5.48122 3.98122 4.25 5.5 4.25H18.5C20.0188 4.25 21.25 5.48122 21.25 7V17C21.25 18.5188 20.0188 19.75 18.5 19.75H5.5C3.98122 19.75 2.75 18.5188 2.75 17V7ZM5.5 5.75C4.80964 5.75 4.25 6.30964 4.25 7V8.25H19.75V7C19.75 6.30964 19.1904 5.75 18.5 5.75H5.5ZM19.75 9.75H4.25V17C4.25 17.6904 4.80964 18.25 5.5 18.25H18.5C19.1904 18.25 19.75 17.6904 19.75 17V9.75ZM14.75 13.5C14.75 12.8096 15.3096 12.25 16 12.25H17C17.6904 12.25 18.25 12.8096 18.25 13.5C18.25 14.1904 17.6904 14.75 17 14.75H16C15.3096 14.75 14.75 14.1904 14.75 13.5Z" fill="" />
              </svg>
              <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Iuran Warga</span>
              <svg
                class="menu-item-arrow absolute right-2.5 top-1/2 -translate-y-1/2 stroke-current"
                :class="[(selected === 'Iuran') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive', sidebarToggle ? 'lg:hidden' : '']"
                width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"
              >
                <path d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </a>

            <div class="overflow-hidden transform translate" :class="(selected === 'Iuran') ? 'block' : 'hidden'">
              <ul :class="sidebarToggle ? 'lg:hidden' : 'flex'" class="flex flex-col gap-1 mt-2 menu-dropdown pl-9">

                @if (auth()->user()->role === 'admin')
                  <li>
                    <a href="#" class="menu-dropdown-item group" :class="page === 'iuranKelola' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'">
                      Kelola Iuran
                    </a>
                  </li>
                  <li>
                    <a href="#" class="menu-dropdown-item group" :class="page === 'iuranRiwayat' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'">
                      Riwayat Pembayaran
                    </a>
                  </li>
                @else
                  <li>
                    <a href="#" class="menu-dropdown-item group" :class="page === 'iuranTagihan' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'">
                      Tagihan Iuran Saya
                    </a>
                  </li>
                  <li>
                    <a href="#" class="menu-dropdown-item group" :class="page === 'iuranRiwayat' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'">
                      Riwayat Bayar
                    </a>
                  </li>
                @endif

              </ul>
            </div>
          </li>
          {{-- END IURAN --}}

        </ul>
      </div>
      {{-- END MENU GROUP: KEUANGAN --}}


      {{-- ======================================== --}}
      {{-- MENU GROUP: ADMIN ONLY                   --}}
      {{-- Seluruh group ini hanya tampil untuk ADMIN --}}
      {{-- ======================================== --}}
      @if (auth()->user()->role === 'admin')
      <div>
        <h3 class="mb-4 text-xs uppercase leading-[20px] text-gray-400">
          <span class="menu-group-title" :class="sidebarToggle ? 'lg:hidden' : ''">Manajemen</span>
          <svg
            :class="sidebarToggle ? 'lg:block hidden' : 'hidden'"
            class="mx-auto fill-current menu-group-icon"
            width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
          >
            <path fill-rule="evenodd" clip-rule="evenodd" d="M5.99915 10.2451C6.96564 10.2451 7.74915 11.0286 7.74915 11.9951V12.0051C7.74915 12.9716 6.96564 13.7551 5.99915 13.7551C5.03265 13.7551 4.24915 12.9716 4.24915 12.0051V11.9951C4.24915 11.0286 5.03265 10.2451 5.99915 10.2451ZM17.9991 10.2451C18.9656 10.2451 19.7491 11.0286 19.7491 11.9951V12.0051C19.7491 12.9716 18.9656 13.7551 17.9991 13.7551C17.0326 13.7551 16.2491 12.9716 16.2491 12.0051V11.9951C16.2491 11.0286 17.0326 10.2451 17.9991 10.2451ZM13.7491 11.9951C13.7491 11.0286 12.9656 10.2451 11.9991 10.2451C11.0326 10.2451 10.2491 11.0286 10.2491 11.9951V12.0051C10.2491 12.9716 11.0326 13.7551 11.9991 13.7551C12.9656 13.7551 13.7491 12.9716 13.7491 12.0051V11.9951Z" fill="" />
          </svg>
        </h3>

        <ul class="flex flex-col gap-4 mb-6">

          {{-- ============================ --}}
          {{-- MENU ITEM: MANAJEMEN WARGA   --}}
          {{-- ADMIN ONLY                   --}}
          {{-- ============================ --}}
          <li>
            <a
              href="#"
              class="menu-item group"
              {{-- Class Active: Jika sedang dipilih ATAU route saat ini adalah bagian dari warga --}}
              :class="(selected === 'DataWarga' || '{{ request()->routeIs('admin.warga.*') }}') ? 'menu-item-active' : 'menu-item-inactive'"
              @click.prevent="selected = (selected === 'DataWarga' ? '' : 'DataWarga')"
            >
              {{-- Icon Users --}}
             <svg
                :class="(selected === 'DataWarga' || '{{ request()->routeIs('admin.warga.*') }}') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
                width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
              >
                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.75 6.5C8.75 4.84315 10.0931 3.5 11.75 3.5C13.4069 3.5 14.75 4.84315 14.75 6.5C14.75 8.15685 13.4069 9.5 11.75 9.5C10.0931 9.5 8.75 8.15685 8.75 6.5ZM11.75 2C9.26472 2 7.25 4.01472 7.25 6.5C7.25 8.98528 9.26472 11 11.75 11C14.2353 11 16.25 8.98528 16.25 6.5C16.25 4.01472 14.2353 2 11.75 2ZM7.25 13.5C5.18957 13.5 3.5 15.1896 3.5 17.25V19.25C3.5 19.6642 3.83579 20 4.25 20C4.66421 20 5 19.6642 5 19.25V17.25C5 16.0179 6.01793 15 7.25 15H16.25C17.4821 15 18.5 16.0179 18.5 17.25V19.25C18.5 19.6642 18.8358 20 19.25 20C19.6642 20 20 19.6642 20 19.25V17.25C20 15.1896 18.3104 13.5 16.25 13.5H7.25Z" fill="currentColor" />
              </svg>
              <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Data Warga</span>
              <svg
                class="menu-item-arrow absolute right-2.5 top-1/2 -translate-y-1/2 stroke-current"
                :class="[(selected === 'DataWarga') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive', sidebarToggle ? 'lg:hidden' : '']"
                width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"
              >
                <path d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </a>

            <div class="overflow-hidden transform translate" :class="(selected === 'DataWarga') ? 'block' : 'hidden'">
              <ul :class="sidebarToggle ? 'lg:hidden' : 'flex'" class="flex flex-col gap-1 mt-2 menu-dropdown pl-9">
                <li>
                  <a 
                    href="{{ route('admin.warga.index') }}" 
                    {{-- Class Active khusus untuk sub-menu --}}
                    class="menu-dropdown-item group {{ request()->routeIs('admin.warga.index') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}"
                  >
                    Daftar Kartu Keluarga
                  </a>
                </li>
                <li>
                  <a 
                    href="{{ route('admin.warga.semua') }}" 
                    {{-- Class Active khusus untuk sub-menu --}}
                    class="menu-dropdown-item group {{ request()->routeIs('admin.warga.semua') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}"
                  >
                    List Semua Warga
                  </a>
                </li>
                {{-- <li>
                  <a 
                    href="{{ route('admin.warga.index') }}" 
                    class="menu-dropdown-item group {{ request()->routeIs('admin.warga.index') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}"
                  >
                    Daftar Warga
                  </a>
                </li> --}}
                <li>
                  <a href="{{route('admin.warga.kategoriEkonomi')}}" class="menu-dropdown-item group {{ request()->routeIs('admin.warga.kategoriEkonomi') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive' }}">
                    Kategori Ekonomi Warga
                  </a>
                </li>
              </ul>
            </div>
          </li>
          {{-- END MANAJEMEN WARGA --}}

        </ul>
      </div>
      {{-- END MENU GROUP: ADMIN ONLY --}}
      @endif


      {{-- ======================================== --}}
      {{-- MENU GROUP: AKUN                         --}}
      {{-- Tampil untuk ADMIN & WARGA               --}}
      {{-- ======================================== --}}
      <div>
        <h3 class="mb-4 text-xs uppercase leading-[20px] text-gray-400">
          <span class="menu-group-title" :class="sidebarToggle ? 'lg:hidden' : ''">Akun</span>
          <svg
            :class="sidebarToggle ? 'lg:block hidden' : 'hidden'"
            class="mx-auto fill-current menu-group-icon"
            width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
          >
            <path fill-rule="evenodd" clip-rule="evenodd" d="M5.99915 10.2451C6.96564 10.2451 7.74915 11.0286 7.74915 11.9951V12.0051C7.74915 12.9716 6.96564 13.7551 5.99915 13.7551C5.03265 13.7551 4.24915 12.9716 4.24915 12.0051V11.9951C4.24915 11.0286 5.03265 10.2451 5.99915 10.2451ZM17.9991 10.2451C18.9656 10.2451 19.7491 11.0286 19.7491 11.9951V12.0051C19.7491 12.9716 18.9656 13.7551 17.9991 13.7551C17.0326 13.7551 16.2491 12.9716 16.2491 12.0051V11.9951C16.2491 11.0286 17.0326 10.2451 17.9991 10.2451ZM13.7491 11.9951C13.7491 11.0286 12.9656 10.2451 11.9991 10.2451C11.0326 10.2451 10.2491 11.0286 10.2491 11.9951V12.0051C10.2491 12.9716 11.0326 13.7551 11.9991 13.7551C12.9656 13.7551 13.7491 12.9716 13.7491 12.0051V11.9951Z" fill="" />
          </svg>
        </h3>

        <ul class="flex flex-col gap-4 mb-6">

          {{-- ========================= --}}
          {{-- MENU ITEM: PROFIL SAYA   --}}
          {{-- ========================= --}}
          <li>
            <a
              href="#"
              class="menu-item group"
              :class="(selected === 'Profil') && (page === 'profil') ? 'menu-item-active' : 'menu-item-inactive'"
              @click="selected = (selected === 'Profil' ? '' : 'Profil')"
            >
              {{-- Icon Profile --}}
              <svg
                :class="(selected === 'Profil') && (page === 'profil') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
                width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
              >
                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 3.5C7.30558 3.5 3.5 7.30558 3.5 12C3.5 14.1526 4.3002 16.1184 5.61936 17.616C6.17279 15.3096 8.24852 13.5955 10.7246 13.5955H13.2746C15.7509 13.5955 17.8268 15.31 18.38 17.6167C19.6996 16.119 20.5 14.153 20.5 12C20.5 7.30558 16.6944 3.5 12 3.5ZM17.0246 18.8566V18.8455C17.0246 16.7744 15.3457 15.0955 13.2746 15.0955H10.7246C8.65354 15.0955 6.97461 16.7744 6.97461 18.8455V18.856C8.38223 19.8895 10.1198 20.5 12 20.5C13.8798 20.5 15.6171 19.8898 17.0246 18.8566ZM2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12ZM11.9991 7.25C10.8847 7.25 9.98126 8.15342 9.98126 9.26784C9.98126 10.3823 10.8847 11.2857 11.9991 11.2857C13.1135 11.2857 14.0169 10.3823 14.0169 9.26784C14.0169 8.15342 13.1135 7.25 11.9991 7.25ZM8.48126 9.26784C8.48126 7.32499 10.0563 5.75 11.9991 5.75C13.9419 5.75 15.5169 7.32499 15.5169 9.26784C15.5169 11.2107 13.9419 12.7857 11.9991 12.7857C10.0563 12.7857 8.48126 11.2107 8.48126 9.26784Z" fill="" />
              </svg>
              <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Profil Saya</span>
            </a>
          </li>
          {{-- END PROFIL --}}

        </ul>
      </div>
      {{-- END MENU GROUP: AKUN --}}

    </nav>
    <!-- Sidebar Menu -->
  </div>
</aside>