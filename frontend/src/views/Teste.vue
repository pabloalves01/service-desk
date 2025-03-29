<template>
    <div class="sidenav" :class="{ 'dark': isDarkMode }">
      <div class="w-64 h-screen bg-zinc-950 dark:bg-zinc-950 border-r border-gray-800 overflow-y-auto">
        <!-- Company header -->
        <div class="flex items-center justify-between p-4">
          <div class="flex items-center">
            <div class="w-8 h-8 bg-black dark:bg-gray-800 rounded-md flex items-center justify-center">
              <file-text-icon class="w-4 h-4 text-white" />
            </div>
            <div class="ml-3">
              <h3 class="text-sm font-medium text-gray-100">Acme Inc</h3>
              <p class="text-xs text-gray-400">Enterprise</p>
            </div>
          </div>
          <button class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
            <chevron-down-icon class="w-4 h-4" />
          </button>
        </div>
  
        <!-- Navigation -->
        <div class="px-3 py-2">
          <p class="px-3 text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">
            Platform
          </p>
  
          <nav class="space-y-2">
            <!-- Playground with submenu -->
            <div>
              <button 
                @click="toggleSubmenu('playground')" 
                class="flex items-center justify-between w-full px-3 py-2 text-sm text-gray-200 rounded-md hover:bg-zinc-800 transition-colors"
                :class="{ 'bg-zinc-800': activeSubmenu === 'playground' }"
              >
                <div class="flex items-center">
                  <layout-icon class="w-5 h-5 text-gray-400" />
                  <span class="ml-3">Playground</span>
                </div>
                <chevron-down-icon 
                  class="w-4 h-4 text-gray-400 transition-transform duration-200" 
                  :class="{ 'transform rotate-180': activeSubmenu === 'playground' }"
                />
              </button>
  
              <!-- Submenu items -->
              <transition 
                name="submenu-transition" 
                @before-enter="beforeEnter" 
                @enter="enter" 
                @leave="leave"
              >
                <div v-if="activeSubmenu === 'playground'" class="mt-1  space-y-1">
                  <div class="submenu-progress-bar">
                    <div 
                      class="progress-line" 
                      :style="{ height: `${playgroundItems.length * 10}px` }"
                    ></div>
                  </div>
                  <a 
                    v-for="(item, index) in playgroundItems" 
                    :key="index"
                    href="#"
                    class="block px-3 py-2 text-sm text-gray-300 rounded-md hover:bg-zinc-800"
                  >
                    {{ item }}
                  </a>
                </div>
              </transition>
            </div>
  
            <!-- Other menu items -->
            <div v-for="(item, index) in menuItems" :key="index">
              <a 
                v-if="!item.hasSubmenu"
                href="#"
                class="flex items-center justify-between px-3 py-2 text-sm text-gray-200 rounded-md hover:bg-zinc-800 transition-colors"
              >
                <div class="flex items-center">
                  <component :is="item.icon" class="w-5 h-5 text-gray-400" />
                  <span class="ml-3">{{ item.name }}</span>
                </div>
              </a>
              <button 
                v-else
                @click="toggleSubmenu(item.name)"
                class="flex items-center justify-between w-full px-3 py-2 text-sm text-gray-200 rounded-md hover:bg-zinc-800 transition-colors"
                :class="{ 'bg-zinc-800': activeSubmenu === item.name }"
              >
                <div class="flex items-center">
                  <component :is="item.icon" class="w-5 h-5 text-gray-400" />
                  <span class="ml-3">{{ item.name }}</span>
                </div>
                <chevron-right-icon v-if="item.hasSubmenu" class="w-4 h-4 text-gray-400" />
              </button>
  
              <!-- Submenu items -->
              <transition 
                name="submenu-transition" 
                @before-enter="beforeEnter" 
                @enter="enter" 
                @leave="leave"
              >
                <div v-if="activeSubmenu === item.name" class="mt-1 space-y-1">
                  <div class="submenu-progress-bar">
                    <div 
                      class="progress-line" 
                      :style="{ height: `${item.submenu.length * 10}px` }"
                    ></div>
                  </div>
                  <a 
                    v-for="(subitem, subindex) in item.submenu" 
                    :key="subindex"
                    href="#"
                    class="block px-3 py-2 text-sm text-gray-300 rounded-md hover:bg-zinc-800"
                  >
                    {{ subitem }}
                  </a>
                </div>
              </transition>
            </div>
          </nav>
        </div>
  
        <!-- User profile -->
        <div class="absolute bottom-0 w-64 border-t border-gray-800">
          <div class="flex items-center justify-between p-4">
            <div class="flex items-center">
              <img 
                src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/image-bPCCM6lUbXpWelb2K3Qu5yBV8rODZc.png" 
                alt="User avatar" 
                class="w-8 h-8 rounded-full object-cover"
              />
              <div class="ml-3">
                <p class="text-sm font-medium text-gray-100">shadcn</p>
                <p class="text-xs text-gray-400">m@example.com</p>
              </div>
            </div>
            <button class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
              <chevron-down-icon class="w-4 h-4" />
            </button>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
    import { ref } from 'vue';
    import { 
      FileText as FileTextIcon,
      ChevronDown as ChevronDownIcon,
      ChevronRight as ChevronRightIcon,
      Layout as LayoutIcon,
      Box as BoxIcon,
      FileText as DocumentationIcon,
      Settings as SettingsIcon
    } from 'lucide-vue-next';
  
    // State
    const isDarkMode = ref(true);
    const activeSubmenu = ref('playground'); // Set to 'playground' to show it expanded by default
  
    // Menu items
    const playgroundItems = ['History', 'Starred', 'Settings'];
  
    const menuItems = [
      { 
        name: 'Models', 
        icon: BoxIcon, 
        hasSubmenu: true,
        submenu: ['Item 1', 'Item 2', 'Item 3']
      },
      { 
        name: 'Documentation', 
        icon: DocumentationIcon, 
        hasSubmenu: false
      },
      { 
        name: 'Settings', 
        icon: SettingsIcon, 
        hasSubmenu: true,
        submenu: ['Account', 'Preferences']
      }
    ];
  
    // Toggle submenu
    const toggleSubmenu = (menu) => {
      if (activeSubmenu.value === menu) {
        activeSubmenu.value = null;
      } else {
        activeSubmenu.value = menu;
      }
    };
  
    // Transition hooks
    const beforeEnter = (el) => {
      el.style.height = '0';
    };
  
    const enter = (el, done) => {
      el.offsetHeight; // trigger reflow
      el.style.transition = 'height 0.3s ease-in-out';
      el.style.height = `${el.scrollHeight}px`;
      done();
    };
  
    const leave = (el, done) => {
      el.style.transition = 'height 0.3s ease-in-out';
      el.style.height = '0';
      done();
    };
  </script>
  
  <style scoped>
    /* Ensure the sidenav takes full height */
    .sidenav {
      height: 100vh;
      position: relative;
    }
  
    /* Add some custom scrollbar styling */
    .sidenav div::-webkit-scrollbar {
      width: 4px;
    }
  
    .sidenav div::-webkit-scrollbar-track {
      background: transparent;
    }
  
    .sidenav div::-webkit-scrollbar-thumb {
      background-color: rgba(156, 163, 175, 0.3);
      border-radius: 20px;
    }
  
    /* Ensure dark mode works properly */
    .dark {
      color-scheme: dark;
    }
  
    /* Smooth transition for the submenu */
    .submenu-transition-enter-active, 
    .submenu-transition-leave-active {
      transition: height 0.3s ease-in-out;
    }
  
    .submenu-transition-enter, 
    .submenu-transition-leave-to /* .submenu-transition-leave-active in <2.1.8 */ {
      height: 0;
    }
  
    /* Styling for the progress bar */
    .submenu-progress-bar {
      position: absolute;
      left: 0;
      top: 0;
      width: 4px;
      background-color: #4B5563;
      border-radius: 2px;
      z-index: -1;
    }
  
    .progress-line {
      background-color: #9CA3AF;
      width: 100%;
    }
  </style>
  