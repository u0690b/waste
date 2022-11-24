<template>
  <div class="overflow-x-auto max-w-[calc(100vw-250px)] ">
    <table class="w-full text-sm whitespace-no-wrap">
      <tr class="font-bold text-left">
        <th class="pl-2">№</th>
        <th v-for="header,i in Object.values(headers)" :key="i" class="px-2 pt-2 pb-1" @click="$emit('orderBy',i)">{{ header }}</th>
      </tr>
      <tr v-for="row,index in datas.data" :key="row.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
        <td class="pl-2 border-t">{{ index+1 }}</td>
        <td v-for="key,i in Object.keys(headers)" :key="i" class="px-2 py-2 border-t">
          <inertia-link v-if="routeUrl" :href="route(routeUrl, row.id)" class="flex items-center focus:text-indigo-500">
            {{ parseVal(row,key) }} 
          </inertia-link>
          <span v-else class="items-center ">{{ parseVal(row,key) }}</span>
        </td>
      </tr>
      <tr v-if="datas.length === 0">
        <td class="px-6 py-4 border-t" colspan="4">
          No Common Types found.
        </td>
      </tr>
    </table>
  </div>
</template>

<script>
import Icon from './Icon.vue'
export default {
  components: { Icon },
  props:{
    headers: { type: Object, required:true},
    datas: { type:Object, required:true},
    routeUrl:String,
  },
  emits: ['orderBy'],
  setup(props){
    
    const parseVal=(row,key)=>{
      
      let ret = ''
      let keys = key.split('.')
      if(keys.length==1){
        ret = row[keys[0]]
      }else{
        if(row[keys[0]]&&row[keys[0]][keys[1]])
          ret =  row[keys[0]][keys[1]]??''
        else ret=''
      }
      
      
      return ret
    }
    
    return {
      parseVal,
    }
  },
}
</script>