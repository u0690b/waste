<template>
  <div>
    
    <inertia-link :href="route('admin.attached_files.index')" :class="{'bg-gray-200':isUrl('admin.attached_files.index')}" class="flex items-center w-full h-10 pl-4 text-blue-400 rounded-lg cursor-pointer hover:bg-gray-200">
      <span class="text-gray-700">Attached Files</span>
    </inertia-link>
    <inertia-link :href="route('admin.bag_horoos.index')" :class="{'bg-gray-200':isUrl('admin.bag_horoos.index')}" class="flex items-center w-full h-10 pl-4 text-blue-400 rounded-lg cursor-pointer hover:bg-gray-200">
      <span class="text-gray-700">Bag Horoos</span>
    </inertia-link>
    <inertia-link :href="route('admin.places.index')" :class="{'bg-gray-200':isUrl('admin.places.index')}" class="flex items-center w-full h-10 pl-4 text-blue-400 rounded-lg cursor-pointer hover:bg-gray-200">
      <span class="text-gray-700">Places</span>
    </inertia-link>
    <inertia-link :href="route('admin.reasons.index')" :class="{'bg-gray-200':isUrl('admin.reasons.index')}" class="flex items-center w-full h-10 pl-4 text-blue-400 rounded-lg cursor-pointer hover:bg-gray-200">
      <span class="text-gray-700">Reasons</span>
    </inertia-link>
    <inertia-link :href="route('admin.statuses.index')" :class="{'bg-gray-200':isUrl('admin.statuses.index')}" class="flex items-center w-full h-10 pl-4 text-blue-400 rounded-lg cursor-pointer hover:bg-gray-200">
      <span class="text-gray-700">Statuses</span>
    </inertia-link>
    <inertia-link :href="route('admin.registers.index')" :class="{'bg-gray-200':isUrl('admin.registers.index')}" class="flex items-center w-full h-10 pl-4 text-blue-400 rounded-lg cursor-pointer hover:bg-gray-200">
      <span class="text-gray-700">Registers</span>
    </inertia-link>
    <inertia-link :href="route('admin.register_histories.index')" :class="{'bg-gray-200':isUrl('admin.register_histories.index')}" class="flex items-center w-full h-10 pl-4 text-blue-400 rounded-lg cursor-pointer hover:bg-gray-200">
      <span class="text-gray-700">Register Histories</span>
    </inertia-link>
    <inertia-link :href="route('admin.aimag_cities.index')" :class="{'bg-gray-200':isUrl('admin.aimag_cities.index')}" class="flex items-center w-full h-10 pl-4 text-blue-400 rounded-lg cursor-pointer hover:bg-gray-200">
      <span class="text-gray-700">Aimag Cities</span>
    </inertia-link>
    <inertia-link :href="route('admin.soum_districts.index')" :class="{'bg-gray-200':isUrl('admin.soum_districts.index')}" class="flex items-center w-full h-10 pl-4 text-blue-400 rounded-lg cursor-pointer hover:bg-gray-200">
      <span class="text-gray-700">Soum Districts</span>
    </inertia-link>
    <inertia-link :href="route('admin.aimag_cities.index')" :class="{'bg-gray-200':isUrl('admin.aimag_cities.index')}" class="flex items-center w-full h-10 pl-4 text-blue-400 rounded-lg cursor-pointer hover:bg-gray-200">
      <span class="text-gray-700">Aimag Cities</span>
    </inertia-link>
    <inertia-link :href="route('admin.soum_districts.index')" :class="{'bg-gray-200':isUrl('admin.soum_districts.index')}" class="flex items-center w-full h-10 pl-4 text-blue-400 rounded-lg cursor-pointer hover:bg-gray-200">
      <span class="text-gray-700">Soum Districts</span>
    </inertia-link>
    <inertia-link :href="route('admin.bag_horoos.index')" :class="{'bg-gray-200':isUrl('admin.bag_horoos.index')}" class="flex items-center w-full h-10 pl-4 text-blue-400 rounded-lg cursor-pointer hover:bg-gray-200">
      <span class="text-gray-700">Bag Horoos</span>
    </inertia-link>
    <inertia-link :href="route('admin.places.index')" :class="{'bg-gray-200':isUrl('admin.places.index')}" class="flex items-center w-full h-10 pl-4 text-blue-400 rounded-lg cursor-pointer hover:bg-gray-200">
      <span class="text-gray-700">Places</span>
    </inertia-link>
    <inertia-link :href="route('admin.reasons.index')" :class="{'bg-gray-200':isUrl('admin.reasons.index')}" class="flex items-center w-full h-10 pl-4 text-blue-400 rounded-lg cursor-pointer hover:bg-gray-200">
      <span class="text-gray-700">Reasons</span>
    </inertia-link>
    <inertia-link :href="route('admin.statuses.index')" :class="{'bg-gray-200':isUrl('admin.statuses.index')}" class="flex items-center w-full h-10 pl-4 text-blue-400 rounded-lg cursor-pointer hover:bg-gray-200">
      <span class="text-gray-700">Statuses</span>
    </inertia-link>
    <inertia-link :href="route('admin.registers.index')" :class="{'bg-gray-200':isUrl('admin.registers.index')}" class="flex items-center w-full h-10 pl-4 text-blue-400 rounded-lg cursor-pointer hover:bg-gray-200">
      <span class="text-gray-700">Registers</span>
    </inertia-link>
    <inertia-link :href="route('admin.attached_files.index')" :class="{'bg-gray-200':isUrl('admin.attached_files.index')}" class="flex items-center w-full h-10 pl-4 text-blue-400 rounded-lg cursor-pointer hover:bg-gray-200">
      <span class="text-gray-700">Attached Files</span>
    </inertia-link>
    <inertia-link :href="route('admin.register_histories.index')" :class="{'bg-gray-200':isUrl('admin.register_histories.index')}" class="flex items-center w-full h-10 pl-4 text-blue-400 rounded-lg cursor-pointer hover:bg-gray-200">
      <span class="text-gray-700">Register Histories</span>
    </inertia-link>
    <inertia-link :href="route('admin.register_histories.index')" :class="{'bg-gray-200':isUrl('admin.register_histories.index')}" class="flex items-center w-full h-10 pl-4 text-blue-400 rounded-lg cursor-pointer hover:bg-gray-200">
      <span class="text-gray-700">Register Histories</span>
    </inertia-link>
    <inertia-link :href="route('admin.registers.index')" :class="{'bg-gray-200':isUrl('admin.registers.index')}" class="flex items-center w-full h-10 pl-4 text-blue-400 rounded-lg cursor-pointer hover:bg-gray-200">
      <span class="text-gray-700">Registers</span>
    </inertia-link>
  </div>
</template>

<script>

export default {
  components: {
    
  },
  methods: {
    isUrl(...urls) {
      
      let currentUrl = this.$page.url.substr(1)
      if (urls[0] === '') {
        return currentUrl === ''
      }
      return urls.filter(url => currentUrl.startsWith(url)).length
    },
  },
}
</script>
