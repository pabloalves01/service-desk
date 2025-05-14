<template>
  <div class="sidebar-container" :class="{ 'collapsed': isCollapsed }">
    <!-- Logo and toggle button -->
    <div class="sidebar-header">
      <div class="logo-container">
        <div class="logo">
          <layout-icon class="logo-icon" />
        </div>
        <span class="logo-text" v-show="!isCollapsed">{{ logoText }}</span>
      </div>
      <button @click="toggleSidebar" class="toggle-button">
        <chevron-left-icon :class="{ 'rotate-180': isCollapsed }" />
      </button>
    </div>

    <!-- Search bar -->
    <div class="search-container" v-show="!isCollapsed">
      <div class="search-input">
        <search-icon class="search-icon" />
        <input type="text" placeholder="Buscar..." />
      </div>
    </div>

    <!-- Navigation -->
    <div class="nav-container">
      <div v-for="(section, sectionIndex) in navigationSections" :key="sectionIndex" class="nav-section">
        <div class="section-title" v-show="!isCollapsed">{{ section.title }}</div>
        
        <div v-for="(item, itemIndex) in section.items" :key="itemIndex" class="nav-item-wrapper">
          <!-- Regular menu item -->
          <router-link 
            v-if="!item.children" 
            :to="item.path" 
            class="nav-item"
            :class="{ 'active': currentPath === item.path }"
          >
            <component :is="item.icon" class="nav-icon" />
            <span class="nav-text" v-show="!isCollapsed">{{ item.name }}</span>
            <div v-if="item.badge" class="badge" v-show="!isCollapsed">{{ item.badge }}</div>
          </router-link>

          <!-- Collapsible menu item with children -->
          <div v-else class="nav-item-collapsible">
            <div 
              @click="toggleSubmenu(item)" 
              class="nav-item"
              :class="{ 'active': isSubmenuActive(item) }"
            >
              <component :is="item.icon" class="nav-icon" />
              <span class="nav-text" v-show="!isCollapsed">{{ item.name }}</span>
              <chevron-down-icon 
                v-show="!isCollapsed" 
                class="submenu-arrow"
                :class="{ 'rotate-180': item.expanded }"
              />
            </div>

            <!-- Submenu -->
            <transition name="submenu">
              <div v-if="item.expanded && !isCollapsed" class="submenu">
                <router-link 
                  v-for="(child, childIndex) in item.children" 
                  :key="childIndex"
                  :to="child.path"
                  class="submenu-item"
                  :class="{ 'active': currentPath === child.path }"
                >
                  {{ child.name }}
                </router-link>
              </div>
            </transition>
          </div>
        </div>
      </div>
    </div>

    <!-- User profile -->
    <div class="user-profile">
      <div class="user-avatar">
        <img :src="userAvatar" alt="User Avatar" />
      </div>
      <div class="user-info" v-show="!isCollapsed">
        <div class="user-name">{{ userName }}</div>
        <div class="user-email">{{ userEmail }}</div>
      </div>
      <button class="user-menu-button" v-show="!isCollapsed">
        <chevron-down-icon />
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import {
  ChevronLeft as ChevronLeftIcon,
  ChevronDown as ChevronDownIcon,
  Search as SearchIcon,
  Layout as LayoutIcon,
  Home as HomeIcon,
  Bookmark as BookmarkIcon,
  BarChart2 as ChartIcon,
  Users as UsersIcon,
  MessageSquare as MessageIcon,
  Calendar as CalendarIcon,
  Settings as SettingsIcon,
  Folder as FolderIcon,
  Calendar,
  Cake,
  Users,
} from 'lucide-vue-next';

// Props with defaults
const props = defineProps({
  defaultCollapsed: {
    type: Boolean,
    default: false
  },
  userAvatar: {
    type: String,
    default: 'https://primefaces.org/cdn/primevue/images/avatar/amyelsner.png'
  },
  userName: {
    type: String,
    default: 'Desenvolvedor'
  },
  userEmail: {
    type: String,
    default: 'admin@admin.com'
  },
  logoText: {
    type: String,
    default: 'Sua Logo'
  }
});

// Emits
const emit = defineEmits(['collapse-change']);

// State

const isCollapsed = ref(props.defaultCollapsed);
const route = useRoute();
const showLogoText = ref(!isCollapsed.value);
const showSearch = ref(!isCollapsed.value);
const showSectionTitle = ref(!isCollapsed.value);
const showNavItemText = ref(!isCollapsed.value);
const showBadge = ref(!isCollapsed.value);
const showSubmenuArrow = ref(!isCollapsed.value);
const showUserInfo = ref(!isCollapsed.value);
const showUserMenuButton = ref(!isCollapsed.value);
  
// Computed
const currentPath = computed(() => route.path);

// Navigation data
const navigationSections = ref([
  {
    title: 'PRINCIPAIS',
    items: [
      { name: 'Eventos', path: '/', icon: Calendar },
      { name: 'Imóveis', path: '/imoveis', icon: BookmarkIcon },
      { 
        name: 'Relatórios', 
        path: '/relatorios', 
        icon: ChartIcon,
        expanded: false,
        children: [
          { name: 'Revenue', path: '/reports/revenue' },
          { name: 'Expenses', path: '/reports/expenses' }
        ]
      },
      { name: 'Equipe', path: '/team', icon: UsersIcon },
      { name: 'Mensagens', path: '/messages', icon: MessageIcon, badge: '3' },
      { name: 'Calendário', path: '/calendar', icon: CalendarIcon },
    ]
  },
   {
    title: 'ADMINISTRATIVO',
    items: [
      { name: 'Aniversáriantes', path: '/gerenciar-aniversariantes', icon: Cake },
      { name: 'Setores', path: '/gerenciar-setores', icon: Users },
      // { 
      //   name: 'Relatórios', 
      //   path: '/relatorios', 
      //   icon: ChartIcon,
      //   expanded: false,
      //   children: [
      //     { name: 'Revenue', path: '/reports/revenue' },
      //     { name: 'Expenses', path: '/reports/expenses' }
      //   ]
      // },
      { name: 'Calendário', path: '/calendar', icon: CalendarIcon },
    ]
  },
  {
    title: 'APLICAÇÃO',
    items: [
      { name: 'Projects', path: '/projects', icon: FolderIcon },
      { name: 'Performance', path: '/performance', icon: ChartIcon },
      { name: 'Configurações', path: '/configuracoes', icon: SettingsIcon },
    ]
  }
]);

// Methods
const toggleSidebar = () => {
  isCollapsed.value = !isCollapsed.value;
  showLogoText.value = !isCollapsed.value;
  showSearch.value = !isCollapsed.value;
  showSectionTitle.value = !isCollapsed.value;
  showNavItemText.value = !isCollapsed.value;
  showBadge.value = !isCollapsed.value;
  showSubmenuArrow.value = !isCollapsed.value;
  showUserInfo.value = !isCollapsed.value;
  showUserMenuButton.value = !isCollapsed.value;

  emit('collapse-change', isCollapsed.value);
  
  // Save state to localStorage
  localStorage.setItem('sidebar-collapsed', isCollapsed.value);
};

const toggleSubmenu = (item) => {
  if (isCollapsed.value) {
    isCollapsed.value = false;
    showLogoText.value = !isCollapsed.value;
    showSearch.value = !isCollapsed.value;
    showSectionTitle.value = !isCollapsed.value;
    showNavItemText.value = !isCollapsed.value;
    showBadge.value = !isCollapsed.value;
    showSubmenuArrow.value = !isCollapsed.value;
    showUserInfo.value = !isCollapsed.value;
    showUserMenuButton.value = !isCollapsed.value;
    item.expanded = true;
  } else {
    item.expanded = !item.expanded;
  }
};

const isSubmenuActive = (item) => {
  if (!item.children) return false;
  return item.children.some(child => child.path === currentPath.value) || item.expanded;
};

// Load collapsed state from localStorage on mount
onMounted(() => {
  const savedState = localStorage.getItem('sidebar-collapsed');
  if (savedState !== null) {
    isCollapsed.value = savedState === 'true';
    showLogoText.value = !isCollapsed.value;
    showSearch.value = !isCollapsed.value;
    showSectionTitle.value = !isCollapsed.value;
    showNavItemText.value = !isCollapsed.value;
    showBadge.value = !isCollapsed.value;
    showSubmenuArrow.value = !isCollapsed.value;
    showUserInfo.value = !isCollapsed.value;
    showUserMenuButton.value = !isCollapsed.value;
  }
});
</script>

<style scoped>
.sidebar-container {
  display: flex;
  flex-direction: column;
  width: 260px;
  height: 100%;
  background-color: black;
  color: #f3f4f6;
  transition: width 0.3s ease;
  position: relative;
  overflow-x: hidden;
  overflow-y: auto;
}

.sidebar-container.collapsed {
  width: 70px;
}

.sidebar-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 16px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.logo-container {
  display: flex;
  align-items: center;
  gap: 12px;
}

.logo {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 32px;
  height: 32px;
  background-color: #4f46e5;
  border-radius: 8px;
}

.logo-icon {
  width: 18px;
  height: 18px;
  color: white;
}

.logo-text {
  font-weight: 600;
  font-size: 16px;
  white-space: nowrap;
}

.toggle-button {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 24px;
  height: 24px;
  border-radius: 4px;
  background: transparent;
  border: none;
  color: #9ca3af;
  cursor: pointer;
  transition: transform 0.3s ease;
}

.toggle-button:hover {
  color: #f3f4f6;
  background-color: rgba(255, 255, 255, 0.1);
}

.rotate-180 {
  transform: rotate(180deg);
}

.search-container {
  padding: 16px;
}

.search-input {
  display: flex;
  align-items: center;
  background-color: rgba(255, 255, 255, 0.1);
  border-radius: 6px;
  padding: 8px 12px;
}

.search-icon {
  width: 16px;
  height: 16px;
  color: #9ca3af;
  margin-right: 8px;
}

.search-input input {
  background: transparent;
  border: none;
  color: #f3f4f6;
  width: 100%;
  outline: none;
  font-size: 14px;
}

.search-input input::placeholder {
  color: #9ca3af;
}

.nav-container {
  flex: 1;
  display: flex;
  flex-direction: column;
  padding: 8px 0;
  overflow-y: auto;
}

.nav-section {
  margin-bottom: 16px;
}

.section-title {
  padding: 8px 16px;
  font-size: 12px;
  font-weight: 600;
  color: #9ca3af;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

.nav-item-wrapper {
  position: relative;
}

.nav-item {
  display: flex;
  align-items: center;
  padding: 10px 16px;
  color: #d1d5db;
  text-decoration: none;
  cursor: pointer;
  transition: background-color 0.2s, color 0.2s;
  border-radius: 6px;
  margin: 0 8px;
  position: relative;
}

.nav-item:hover {
  background-color: rgba(255, 255, 255, 0.1);
  color: #f3f4f6;
}

.nav-item.active {
  background-color: rgba(79, 70, 229, 0.2);
  color: #f3f4f6;
}

.nav-icon {
  width: 20px;
  height: 20px;
  flex-shrink: 0;
}

.nav-text {
  margin-left: 12px;
  font-size: 14px;
  white-space: nowrap;
}

.badge {
  display: flex;
  align-items: center;
  justify-content: center;
  min-width: 20px;
  height: 20px;
  background-color: #4f46e5;
  color: white;
  border-radius: 10px;
  font-size: 12px;
  font-weight: 600;
  margin-left: auto;
  padding: 0 6px;
}

.submenu-arrow {
  width: 16px;
  height: 16px;
  margin-left: auto;
  transition: transform 0.3s ease;
}

.submenu {
  padding-left: 40px;
  overflow: hidden;
}

.submenu-item {
  display: block;
  padding: 8px 16px;
  color: #d1d5db;
  text-decoration: none;
  font-size: 14px;
  border-radius: 6px;
  transition: background-color 0.2s, color 0.2s;
}

.submenu-item:hover {
  background-color: rgba(255, 255, 255, 0.1);
  color: #f3f4f6;
}

.submenu-item.active {
  color: #4f46e5;
  font-weight: 500;
}

.submenu-enter-active,
.submenu-leave-active {
  transition: max-height 0.3s ease, opacity 0.3s ease;
  max-height: 200px;
  opacity: 1;
}

.submenu-enter-from,
.submenu-leave-to {
  max-height: 0;
  opacity: 0;
}

.user-profile {
  display: flex;
  align-items: center;
  padding: 16px;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
  margin-top: auto;
}

.user-avatar {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  overflow: hidden;
  flex-shrink: 0;
}

.user-avatar img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.user-info {
  margin-left: 12px;
  overflow: hidden;
}

.user-name {
  font-size: 14px;
  font-weight: 600;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.user-email {
  font-size: 12px;
  color: #9ca3af;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.user-menu-button {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 24px;
  height: 24px;
  margin-left: auto;
  background: transparent;
  border: none;
  color: #9ca3af;
  cursor: pointer;
}

.user-menu-button:hover {
  color: #f3f4f6;
}

/* Custom scrollbar */
.sidebar-container::-webkit-scrollbar {
  width: 4px;
}

.sidebar-container::-webkit-scrollbar-track {
  background: transparent;
}

.sidebar-container::-webkit-scrollbar-thumb {
  background-color: rgba(156, 163, 175, 0.3);
  border-radius: 20px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .sidebar-container {
    position: fixed;
    z-index: 50;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
  }
}
</style>
