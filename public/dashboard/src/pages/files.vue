<script setup>
import { useRoute } from 'vue-router'
const route = useRoute()
const activeTab = ref(route.params.tab)
// tabs
const tabs = [
  {
    title: 'Uploade Files',
    icon: 'mdi-tray-arrow-up',
    tab: 'uploadFiles',
  },
  {
    title: 'Add Courses',
    icon: 'mdi-book-education-outline',
    tab: 'course',
  },

]

</script>


<template>
    <VTabs
      v-model="activeTab"
      show-arrows
    >
      <VTab
        v-for="item in tabs"
        :key="item.icon"
        :value="item.tab"
      >
        <VIcon
          size="20"
          start
          :icon="item.icon"
        />
        {{ item.title }}
      </VTab>
    </VTabs>
    <VDivider />


    <VWindow
      v-model="activeTab"
      class="mt-5 disable-tab-transition"
    >
     
      <VWindowItem value="uploadFiles">
        <VRow title="Upload Files">

          <VCol cols="12">
           <VCard >
            <VCardText class="d-flex flex-column gap-y-8">
              <v-select
              
              density="comfortable"
              label="Course"
              ></v-select>  
            </VCardText>
            </VCard>
          </VCol>

          <VCol cols="12">
           <VCard >
            <VCardText class="d-flex flex-column gap-y-8">
             <v-file-input
             prepend-icon="mdi-video"
             label="Video input"
             accept="video/*"
             variant="filled"
             @change="handleVideoSelect"
             ></v-file-input>  
            </VCardText>
            </VCard>
          </VCol>

            <VCol cols="12">
             <VCard >
              <VCardText class="d-flex flex-column gap-y-8">
                <v-file-input
                 label="File input"
                 multiple
                 accept=".pdf"
                 variant="filled"
                 @change="handlePDFSelect" 
                ></v-file-input>
              </VCardText>
              </VCard>
            </VCol>
            <VCol cols="12">
             <VCard >
              <VCardText class="d-flex flex-column gap-y-8">
                <v-file-input
                 label="Audio input"
                 prepend-icon="mdi-cast-audio"
                 multiple
                 accept="audio/*"
                 variant="filled"
                 @change="handleVoiceSelect"
                ></v-file-input>
                <VCol
             
             cols="12"
             md="9"
             class="d-flex gap-4"
             >
               <VBtn type="submit">
                 Upload
               </VBtn>
            </VCol>
              </VCardText>
              </VCard>
            </VCol>


         </VRow>
      </VWindowItem>
      <VWindowItem value="course">
        <VRow >
          <VCol cols="12">
           <VCard >
            <VForm @submit.prevent="addCourse">
            <VCardText class="d-flex flex-column gap-y-8">
              <v-text-field
              v-model="form.course_name"
               hide-details="auto"
               label="Course Name"
             ></v-text-field>
             <v-text-field
             v-model="form.course_code"
               hide-details="auto"
               label="Course Code"
             ></v-text-field>
             <VCol
             
              cols="12"
              md="9"
              class="d-flex gap-4"
              >
                <VBtn type="submit">
                  Add
                </VBtn>
             </VCol>
           </VCardText>
          </VForm>
           </VCard>
          </VCol>
      </VRow>
      </VWindowItem>
     
    </VWindow>



  
</template>

<script>

export default {
  data() {
    return {
      form: {
        course_name: '',
        course_code: '',
      
      },
     
    };
  },
  methods: {
    handleVideoSelect(event) {
      const file = event.target.files[0];
      // Handle the selected video file
      console.log('Selected video:', file);
    },
    handlePDFSelect(event) {
      const file = event.target.files[0];
      // Handle the selected PDF file
      console.log('Selected PDF:', file);
    },
    handleVoiceSelect(event) {
      const file = event.target.files[0];
      // Handle the selected voice file
      console.log('Selected voice file:', file);
    },
  },
};
</script>
