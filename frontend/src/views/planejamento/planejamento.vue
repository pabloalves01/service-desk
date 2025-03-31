<template>
    <div class="min-h-screen bg-zinc-900 flex flex-col text-gray-200">
      <!-- Header -->
      <!-- <header class="bg-gray-900 text-white p-4 shadow-md border-b border-gray-800">
        <div class="container mx-auto flex justify-between items-center">
          <h1 class="text-xl font-bold text-purple-400">Service Desk</h1>
          <div class="flex items-center space-x-4">
            <div class="relative">
              <input 
                type="text" 
                placeholder="Buscar chamados..." 
                class="bg-gray-800 px-4 py-2 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 border border-gray-700"
              />
            </div>
            <button class="bg-purple-600 px-4 py-2 rounded-md text-sm hover:bg-purple-700 transition-colors">
              Novo Chamado
            </button>
            <div class="flex items-center space-x-2">
              <span class="text-sm">Olá, Usuário</span>
              <div class="w-8 h-8 rounded-full bg-purple-500 flex items-center justify-center">
                <span class="text-sm font-medium">U</span>
              </div>
            </div>
          </div>
        </div>
      </header> -->
  
      <!-- Calendar Controls -->
      <div class="bg-zinc-900 text-white p-4 border-b border-zinc-800">
        <div class="container mx-auto flex flex-col sm:flex-row justify-between items-center gap-4">
          <div class="flex items-center space-x-4">
            <button @click="navigatePrevious" class="p-2 hover:bg-zinc-950 rounded-md transition-colors">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
              </svg>
            </button>
            <h2 class="text-xl font-semibold">
              <span v-if="viewType === 'month'">{{ currentMonthName }} {{ currentYear }}</span>
              <span v-else-if="viewType === 'week'">Semana de {{ formatDateRange(currentWeekStart, currentWeekEnd) }}</span>
              <span v-else>{{ formatSelectedDay }}</span>
            </h2>
            <button @click="navigateNext" class="p-2 hover:bg-zinc-950 rounded-md transition-colors">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
              </svg>
            </button>
          </div>
          <div class="flex space-x-2">
            <button 
              @click="setViewType('month')" 
              class="px-3 py-1 rounded-md text-sm transition-colors"
              :class="viewType === 'month' ? 'bg-blue-600 text-white' : 'bg-zinc-800 hover:bg-zinc-700'"
            >
              Mês
            </button>
            <button 
              @click="setViewType('week')" 
              class="px-3 py-1 rounded-md text-sm transition-colors"
              :class="viewType === 'week' ? 'bg-blue-600 text-white' : 'bg-zinc-800 hover:bg-zinc-700'"
            >
              Semana
            </button>
            <button 
              @click="setViewType('day')" 
              class="px-3 py-1 rounded-md text-sm transition-colors"
              :class="viewType === 'day' ? 'bg-blue-600 text-white' : 'bg-zinc-800 hover:bg-zinc-700'"
            >
              Dia
            </button>
            <!-- <button @click="today" class="px-3 py-1 bg-gray-800 rounded-md text-sm hover:bg-gray-700 transition-colors">
              Hoje
            </button> -->
          </div>
        </div>
      </div>
  
      <!-- Legend -->
      <!-- <div class="bg-gray-900 px-4 py-2 border-b border-gray-800">
        <div class="container mx-auto flex flex-wrap gap-4 justify-center sm:justify-end">
          <div class="flex items-center">
            <span class="inline-block w-3 h-3 rounded-full bg-red-500 mr-2"></span>
            <span class="text-xs">Alta Prioridade</span>
          </div>
          <div class="flex items-center">
            <span class="inline-block w-3 h-3 rounded-full bg-orange-500 mr-2"></span>
            <span class="text-xs">Média Prioridade</span>
          </div>
          <div class="flex items-center">
            <span class="inline-block w-3 h-3 rounded-full bg-gray-400 mr-2"></span>
            <span class="text-xs">Baixa Prioridade</span>
          </div>
        </div>
      </div> -->
  
      <!-- Calendar View -->
      <div class="flex-1 overflow-auto p-4">
        <div class="container mx-auto bg-gray-900 rounded-lg shadow-xl overflow-hidden border border-zinc-800">
          <!-- Month View -->
          <template v-if="viewType === 'month'">
            <!-- Days of Week Header -->
            <div class="grid grid-cols-7 text-center bg-zinc-950 text-white font-medium border-b border-zinc-700">
              <div v-for="day in daysOfWeek" :key="day" class="py-2 border-r border-gray-700 last:border-r-0">
                {{ day }}
              </div>
            </div>
  
            <!-- Calendar Grid -->
            <div class="grid grid-cols-7 auto-rows-fr bg-zinc-900 text-white">
              <div 
                v-for="(day, index) in calendarDays" 
                :key="index" 
                :class="[
                  'min-h-[120px] border border-gray-800 p-1 relative',
                  {'bg-zinc-950': !day.isCurrentMonth},
                  {'bg-white/15': day.isToday}
                ]"
                @click="selectDay(day.fullDate)"
              >
                <div class="flex justify-between items-center mb-1">
                  <span 
                    :class="[
                      'text-sm rounded-full w-7 h-7 flex items-center justify-center',
                      day.isToday ? 'bg-blue-600 text-white font-bold' : '',
                      !day.isCurrentMonth ? 'text-gray-500' : ''
                    ]"
                  >
                    {{ day.date }}
                  </span>
                </div>
                
                <!-- Tickets for this day -->
                <div class="space-y-1 overflow-y-auto max-h-[100px]">
                  <div 
                    v-for="ticket in getTicketsForDay(day)" 
                    :key="ticket.id"
                    :class="[
                      'text-xs p-1 rounded truncate cursor-pointer hover:bg-opacity-80 transition-colors',
                      getTicketColorClass(ticket.priority)
                    ]"
                    @click.stop="showTicketDetails(ticket)"
                  >
                    <span class="inline-block w-2 h-2 rounded-full mr-1" :class="getTicketDotClass(ticket.priority)"></span>
                    <span class="font-medium mr-1">{{ ticket.time }}</span>
                    <span> {{ ticket.title }}</span>
                  </div>
                </div>
              </div>
            </div>
          </template>
  
          <!-- Week View -->
          <template v-if="viewType === 'week'">
            <!-- Days of Week Header -->
            <div class="grid grid-cols-7 text-center bg-zinc-950 text-white font-medium border-b border-gray-700">
              <div 
                v-for="(day, index) in currentWeekDays" 
                :key="index" 
                class="py-2 border-r border-gray-700 last:border-r-0 flex flex-col"
              >
                <span class="text-xs text-gray-400">{{ getDayName(day.fullDate) }}</span>
                <span 
                  :class="[
                    'text-sm mt-1',
                    day.isToday ? 'bg-blue-600 text-white rounded-full w-7 h-7 flex items-center justify-center mx-auto' : ''
                  ]"
                >
                  {{ day.date }}
                </span>
              </div>
            </div>
  
            <div class="grid grid-cols-7 h-[600px]">
              <div 
                v-for="(day, index) in currentWeekDays" 
                :key="index" 
                class="border border-gray-800 p-2 overflow-y-auto"
                :class="{'bg-purple-900/10': day.isToday}"
                @click="selectDay(day.fullDate)"
              >
                <div 
                  v-for="ticket in getTicketsForDay(day)" 
                  :key="ticket.id"
                  :class="[
                    'p-2 rounded text-sm mb-2 cursor-pointer hover:bg-opacity-80 transition-colors',
                    getTicketColorClass(ticket.priority)
                  ]"
                  @click.stop="showTicketDetails(ticket)"
                >
                  <div class="flex items-center">
                    <span class="inline-block w-3 h-3 rounded-full mr-2" :class="getTicketDotClass(ticket.priority)"></span>
                    <span class="font-bold">{{ ticket.time }}</span>
                  </div>
                  <div class="ml-5 mt-1 line-clamp-2">{{ ticket.title }}</div>
                  <div class="ml-5 text-xs opacity-80">{{ ticket.assignee }}</div>
                </div>
                
                <!-- Empty state -->
                <div 
                  v-if="getTicketsForDay(day).length === 0" 
                  class="h-full flex items-center justify-center text-gray-500 text-sm"
                >
                  Sem chamados
                </div>
              </div>
            </div>
          </template>
  
          <!-- Day View -->
          <template v-if="viewType === 'day'">
            <div class="bg-gray-900 text-white p-4">
              <div class="text-center mb-4">
                <div class="text-xl font-bold">{{ selectedDayName }}</div>
                <div class="text-lg text-gray-400">{{ formatSelectedDay }}</div>
              </div>
              
              <div class="space-y-3 max-w-3xl mx-auto">
                <div 
                  v-for="ticket in selectedDayTickets" 
                  :key="ticket.id"
                  :class="[
                    'p-3 rounded flex items-start cursor-pointer hover:bg-opacity-80 transition-colors',
                    getTicketColorClass(ticket.priority)
                  ]"
                  @click="showTicketDetails(ticket)"
                >
                  <div class="flex-shrink-0 w-16 font-bold">{{ ticket.time }}</div>
                  <div class="flex-1">
                    <div class="font-medium text-lg">{{ ticket.title }}</div>
                    <div class="text-sm opacity-80">
                      <span>Responsável: {{ ticket.assignee }}</span>
                      <span class="mx-2">|</span>
                      <span>Departamento: {{ ticket.department }}</span>
                    </div>
                    <div class="mt-1 text-sm">{{ ticket.description }}</div>
                  </div>
                  <div class="flex-shrink-0 ml-4">
                    <span 
                      class="inline-block px-2 py-1 rounded-full text-xs font-medium"
                      :class="getStatusClass(ticket.status)"
                    >
                      {{ ticket.status }}
                    </span>
                  </div>
                </div>
                
                <!-- Empty state -->
                <div 
                  v-if="selectedDayTickets.length === 0" 
                  class="py-12 flex flex-col items-center justify-center text-gray-500"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                  <p class="text-lg">Nenhum chamado para este dia</p>
                  <button class="mt-4 px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition-colors">
                    Criar Chamado
                  </button>
                </div>
              </div>
            </div>
          </template>
        </div>
      </div>
  
      <!-- Ticket Details Modal -->
      <div v-if="selectedTicket" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50 p-4">
        <div class="bg-gray-900 rounded-lg shadow-xl max-w-2xl w-full overflow-hidden border border-gray-700">
          <div class="flex justify-between items-center p-4 border-b border-gray-700">
            <h3 class="text-xl font-bold text-white">Detalhes do Chamado</h3>
            <button @click="selectedTicket = null" class="text-gray-400 hover:text-white transition-colors">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
          <div class="p-4">
            <div class="mb-4 flex justify-between">
              <span 
                class="inline-block px-3 py-1 rounded-full text-sm font-medium"
                :class="getStatusClass(selectedTicket.status)"
              >
                {{ selectedTicket.status }}
              </span>
              <span 
                class="inline-block px-3 py-1 rounded-full text-sm font-medium"
                :class="getPriorityClass(selectedTicket.priority)"
              >
                {{ getPriorityLabel(selectedTicket.priority) }}
              </span>
            </div>
            
            <h4 class="text-xl font-bold text-white mb-2">{{ selectedTicket.title }}</h4>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4 text-gray-300">
              <div>
                <p class="text-sm text-gray-400">Data e Hora</p>
                <p>{{ formatTicketDate(selectedTicket) }}</p>
              </div>
              <div>
                <p class="text-sm text-gray-400">Responsável</p>
                <p>{{ selectedTicket.assignee }}</p>
              </div>
              <div>
                <p class="text-sm text-gray-400">Departamento</p>
                <p>{{ selectedTicket.department }}</p>
              </div>
              <div>
                <p class="text-sm text-gray-400">Solicitante</p>
                <p>{{ selectedTicket.requester }}</p>
              </div>
            </div>
            
            <div class="mb-4">
              <p class="text-sm text-gray-400 mb-1">Descrição</p>
              <p class="text-white bg-gray-800 p-3 rounded-md">{{ selectedTicket.description }}</p>
            </div>
            
            <div class="border-t border-gray-700 pt-4 mt-4 flex justify-end space-x-3">
              <button class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 transition-colors">
                Editar
              </button>
              <button class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition-colors">
                Atualizar Status
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, computed, onMounted, watch } from 'vue';
  
  // ==========================================
  // STATE MANAGEMENT
  // ==========================================
  
  // View type (month, week, day)
  const viewType = ref('week');
  
  // Current date for navigation
  const currentDate = ref(new Date());
  
  // Selected date for day view
  const selectedDate = ref(new Date());
  
  // Selected ticket for details modal
  const selectedTicket = ref(null);
  
  // Days of the week in Portuguese
  const daysOfWeek = ['DOM', 'SEG', 'TER', 'QUA', 'QUI', 'SEX', 'SÁB'];
  
  // ==========================================
  // DATE UTILITIES
  // ==========================================
  
  // Format a date to string (YYYY-MM-DD)
  const formatDateToString = (date) => {
    return `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;
  };
  
  // Format a date range
  const formatDateRange = (start, end) => {
    const startFormat = new Intl.DateTimeFormat('pt-BR', { day: 'numeric', month: 'short' }).format(start);
    const endFormat = new Intl.DateTimeFormat('pt-BR', { day: 'numeric', month: 'short' }).format(end);
    return `${startFormat} - ${endFormat}`;
  };
  
  // Get day name from date
  const getDayName = (date) => {
    return new Intl.DateTimeFormat('pt-BR', { weekday: 'short' }).format(date);
  };
  
  // Check if two dates are the same day
  const isSameDay = (date1, date2) => {
    return (
      date1.getDate() === date2.getDate() &&
      date1.getMonth() === date2.getMonth() &&
      date1.getFullYear() === date2.getFullYear()
    );
  };
  
  // ==========================================
  // COMPUTED PROPERTIES
  // ==========================================
  
  // Current year and month
  const currentYear = computed(() => currentDate.value.getFullYear());
  const currentMonth = computed(() => currentDate.value.getMonth());
  const currentMonthName = computed(() => {
    return new Intl.DateTimeFormat('pt-BR', { month: 'long' }).format(currentDate.value);
  });
  
  // Format selected day
  const formatSelectedDay = computed(() => {
    return new Intl.DateTimeFormat('pt-BR', { 
      day: 'numeric', 
      month: 'long', 
      year: 'numeric' 
    }).format(selectedDate.value);
  });
  
  // Selected day name
  const selectedDayName = computed(() => {
    return new Intl.DateTimeFormat('pt-BR', { weekday: 'long' }).format(selectedDate.value);
  });
  
  // Week start and end dates
  const currentWeekStart = computed(() => {
    const date = new Date(currentDate.value);
    const day = date.getDay(); // 0 = Sunday, 1 = Monday, etc.
    date.setDate(date.getDate() - day);
    return date;
  });
  
  const currentWeekEnd = computed(() => {
    const date = new Date(currentWeekStart.value);
    date.setDate(date.getDate() + 6);
    return date;
  });
  
  // Calendar days for month view
  const calendarDays = computed(() => {
    const year = currentYear.value;
    const month = currentMonth.value;
    
    // First day of the month
    const firstDay = new Date(year, month, 1);
    // Last day of the month
    const lastDay = new Date(year, month + 1, 0);
    
    // Day of the week for the first day (0 = Sunday, 1 = Monday, etc.)
    const firstDayOfWeek = firstDay.getDay();
    
    // Total days in the month
    const daysInMonth = lastDay.getDate();
    
    // Calendar array
    const days = [];
    
    // Add days from previous month to fill the first week
    const prevMonthLastDay = new Date(year, month, 0).getDate();
    for (let i = firstDayOfWeek - 1; i >= 0; i--) {
      const date = prevMonthLastDay - i;
      const fullDate = new Date(year, month - 1, date);
      days.push({
        date,
        isCurrentMonth: false,
        isToday: isSameDay(fullDate, new Date()),
        fullDate
      });
    }
    
    // Add days of the current month
    const today = new Date();
    for (let date = 1; date <= daysInMonth; date++) {
      const fullDate = new Date(year, month, date);
      days.push({
        date,
        isCurrentMonth: true,
        isToday: isSameDay(fullDate, today),
        fullDate
      });
    }
    
    // Add days from next month to complete the calendar grid
    const remainingDays = 42 - days.length; // 6 rows of 7 days
    for (let date = 1; date <= remainingDays; date++) {
      const fullDate = new Date(year, month + 1, date);
      days.push({
        date,
        isCurrentMonth: false,
        isToday: isSameDay(fullDate, today),
        fullDate
      });
    }
    
    return days;
  });
  
  // Current week days
  const currentWeekDays = computed(() => {
    const days = [];
    const today = new Date();
    
    // Get 7 days starting from Sunday
    for (let i = 0; i < 7; i++) {
      const currentDate = new Date(currentWeekStart.value);
      currentDate.setDate(currentWeekStart.value.getDate() + i);
      
      days.push({
        date: currentDate.getDate(),
        isToday: isSameDay(currentDate, today),
        fullDate: new Date(currentDate)
      });
    }
    
    return days;
  });
  
  // Selected day tickets
  const selectedDayTickets = computed(() => {
    return getTicketsForDay({
      fullDate: selectedDate.value
    });
  });
  
  // ==========================================
  // NAVIGATION METHODS
  // ==========================================
  
  // Set view type
  const setViewType = (type) => {
    viewType.value = type;
  };
  
  // Navigate to previous period
  const navigatePrevious = () => {
    if (viewType.value === 'month') {
      currentDate.value = new Date(currentYear.value, currentMonth.value - 1, 1);
    } else if (viewType.value === 'week') {
      const newDate = new Date(currentDate.value);
      newDate.setDate(newDate.getDate() - 7);
      currentDate.value = newDate;
    } else {
      const newDate = new Date(selectedDate.value);
      newDate.setDate(newDate.getDate() - 1);
      selectedDate.value = newDate;
      currentDate.value = new Date(newDate);
    }
  };
  
  // Navigate to next period
  const navigateNext = () => {
    if (viewType.value === 'month') {
      currentDate.value = new Date(currentYear.value, currentMonth.value + 1, 1);
    } else if (viewType.value === 'week') {
      const newDate = new Date(currentDate.value);
      newDate.setDate(newDate.getDate() + 7);
      currentDate.value = newDate;
    } else {
      const newDate = new Date(selectedDate.value);
      newDate.setDate(newDate.getDate() + 1);
      selectedDate.value = newDate;
      currentDate.value = new Date(newDate);
    }
  };
  
  // Go to today
  const today = () => {
    const now = new Date();
    currentDate.value = new Date(now);
    selectedDate.value = new Date(now);
  };
  
  // Select a specific day
  const selectDay = (date) => {
    selectedDate.value = new Date(date);
    currentDate.value = new Date(date);
    viewType.value = 'day';
  };
  
  // ==========================================
  // TICKET STYLING METHODS
  // ==========================================
  
  // Get background color class for ticket
  const getTicketColorClass = (priority) => {
    switch (priority) {
      case 'high':
        return 'bg-red-950 border border-red-800';
      case 'medium':
        return 'bg-orange-950 border border-orange-800';
      case 'low':
        return 'bg-gray-800 border border-gray-700';
      default:
        return 'bg-gray-800 border border-gray-700';
    }
  };
  
  // Get dot color class for ticket
  const getTicketDotClass = (priority) => {
    switch (priority) {
      case 'high':
        return 'bg-red-500';
      case 'medium':
        return 'bg-orange-500';
      case 'low':
        return 'bg-gray-400';
      default:
        return 'bg-gray-400';
    }
  };
  
  // Get status badge class
  const getStatusClass = (status) => {
    switch (status) {
      case 'Aberto':
        return 'bg-blue-900/60 text-blue-200';
      case 'Em andamento':
        return 'bg-yellow-900/60 text-yellow-200';
      case 'Concluído':
        return 'bg-green-900/60 text-green-200';
      case 'Cancelado':
        return 'bg-red-900/60 text-red-200';
      case 'Agendado':
        return 'bg-purple-900/60 text-purple-200';
      default:
        return 'bg-gray-700 text-gray-200';
    }
  };
  
  // Get priority badge class
  const getPriorityClass = (priority) => {
    switch (priority) {
      case 'high':
        return 'bg-red-900/60 text-red-200';
      case 'medium':
        return 'bg-orange-900/60 text-orange-200';
      case 'low':
        return 'bg-blue-900/60 text-blue-200';
      default:
        return 'bg-gray-700 text-gray-200';
    }
  };
  
  // Get priority label
  const getPriorityLabel = (priority) => {
    switch (priority) {
      case 'high':
        return 'Alta Prioridade';
      case 'medium':
        return 'Média Prioridade';
      case 'low':
        return 'Baixa Prioridade';
      default:
        return 'Normal';
    }
  };
  
  // Format ticket date for display
  const formatTicketDate = (ticket) => {
    const date = new Date(ticket.date);
    return `${new Intl.DateTimeFormat('pt-BR', { 
      day: 'numeric', 
      month: 'long', 
      year: 'numeric' 
    }).format(date)} às ${ticket.time}`;
  };
  
  // ==========================================
  // TICKET INTERACTION METHODS
  // ==========================================
  
  // Show ticket details
  const showTicketDetails = (ticket) => {
    selectedTicket.value = ticket;
  };
  
  // ==========================================
  // TICKET DATA AND FILTERING
  // ==========================================
  
  // Mock data for tickets
  const tickets = ref([
    {
      id: 1,
      title: 'Amanda (faturamento)',
      description: 'Problema com sistema de faturamento. Usuário não consegue emitir notas fiscais.',
      date: '2023-05-01',
      time: '7:55',
      assignee: 'Hamito',
      department: 'Faturamento',
      requester: 'Amanda Silva',
      status: 'Em andamento',
      priority: 'medium'
    },
    {
      id: 2,
      title: 'Rafael Faveri (Implakot)',
      description: 'Configuração de novo equipamento no departamento de implantação.',
      date: '2023-05-01',
      time: '9:10',
      assignee: 'Hamito',
      department: 'Implantação',
      requester: 'Rafael Faveri',
      status: 'Aberto',
      priority: 'low'
    },
    {
      id: 3,
      title: 'Guilherme (faturamento)',
      description: 'Treinamento no novo sistema de faturamento.',
      date: '2023-05-01',
      time: '9:30',
      assignee: 'Augusto',
      department: 'Faturamento',
      requester: 'Guilherme Costa',
      status: 'Agendado',
      priority: 'low'
    },
    {
      id: 4,
      title: 'Cristiane (financeiro)',
      description: 'Problema com relatórios financeiros.',
      date: '2023-05-01',
      time: '8:10',
      assignee: 'Hamito',
      department: 'Financeiro',
      requester: 'Cristiane Oliveira',
      status: 'Em andamento',
      priority: 'high'
    },
    {
      id: 5,
      title: 'Ariel (laboratório resinados)',
      description: 'Manutenção em equipamento do laboratório.',
      date: '2023-05-01',
      time: '16:00',
      assignee: 'Técnico',
      department: 'Laboratório',
      requester: 'Ariel Santos',
      status: 'Agendado',
      priority: 'medium'
    },
    {
      id: 6,
      title: 'Zulmira (A. Comercial)',
      description: 'Configuração de acesso ao sistema comercial.',
      date: '2023-05-01',
      time: '15:30',
      assignee: 'Augusto',
      department: 'Comercial',
      requester: 'Zulmira Pereira',
      status: 'Concluído',
      priority: 'low'
    },
    {
      id: 7,
      title: 'Inkar Gueira',
      description: 'Instalação de software de design.',
      date: '2025-03-30',
      time: '16:30',
      assignee: 'Augusto',
      department: 'Design',
      requester: 'Inkar Gueira',
      status: 'Aberto',
      priority: 'medium'
    },
    {
      id: 8,
      title: 'RH',
      description: 'Configuração de novo usuário no sistema.',
      date: '2023-05-01',
      time: '16:30',
      assignee: 'Hamito',
      department: 'RH',
      requester: 'Departamento RH',
      status: 'Em andamento',
      priority: 'high'
    },
    {
      id: 9,
      title: 'Laboratório',
      description: 'Manutenção preventiva em equipamentos.',
      date: '2023-05-05',
      time: '8:30',
      assignee: 'Augusto',
      department: 'Laboratório',
      requester: 'Coordenador Lab',
      status: 'Agendado',
      priority: 'low'
    },
    {
      id: 10,
      title: 'Recebimento',
      description: 'Treinamento no sistema de recebimento.',
      date: '2023-05-06',
      time: '10:15',
      assignee: 'Augusto',
      department: 'Almoxarifado',
      requester: 'Equipe Recebimento',
      status: 'Agendado',
      priority: 'medium'
    },
    {
      id: 11,
      title: 'Zulmira (A. Comercial)',
      description: 'Problema com acesso ao sistema de vendas.',
      date: '2023-05-12',
      time: '15:00',
      assignee: 'Augusto',
      department: 'Comercial',
      requester: 'Zulmira Pereira',
      status: 'Aberto',
      priority: 'high'
    },
    {
      id: 12,
      title: 'Gabriel (faturamento)',
      description: 'Configuração de impressora fiscal.',
      date: '2023-05-14',
      time: '14:00',
      assignee: 'Augusto',
      department: 'Faturamento',
      requester: 'Gabriel Mendes',
      status: 'Agendado',
      priority: 'medium'
    }
  ]);
  
  // Get tickets for a specific day
  const getTicketsForDay = (day) => {
    if (!day || !day.fullDate) return [];
    
    const date = new Date(day.fullDate);
    const dateString = formatDateToString(date);
    
    return tickets.value.filter(ticket => ticket.date === dateString);
  };
  
  // ==========================================
  // LIFECYCLE HOOKS
  // ==========================================
  
  // Watch for changes in view type
  watch(viewType, (newType) => {
    if (newType === 'day') {
      // When switching to day view, ensure selectedDate is set
      if (!selectedDate.value) {
        selectedDate.value = new Date(currentDate.value);
      }
    } else if (newType === 'week') {
      // When switching to week view, ensure currentDate is set to beginning of week
      const date = new Date(currentDate.value);
      const day = date.getDay();
      if (day !== 0) { // If not Sunday
        date.setDate(date.getDate() - day); // Set to beginning of week (Sunday)
      }
      currentDate.value = date;
    }
  });
  
  // Initialize
  onMounted(() => {
    selectedDate.value = new Date();
    currentDate.value = new Date();
  });
  </script>