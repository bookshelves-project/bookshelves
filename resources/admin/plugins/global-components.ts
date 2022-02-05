import TextField from '@admin/base/fields/TextField.vue'
import EmailField from '@admin/base/fields/EmailField.vue'
import BooleanField from '@admin/base/fields/BooleanField.vue'
import SwitchField from '@admin/base/fields/SwitchField.vue'
import DateField from '@admin/base/fields/DateField.vue'
import SelectField from '@admin/base/fields/SelectField.vue'
import ReferenceField from '@admin/base/fields/ReferenceField.vue'
import ImageField from '@admin/base/fields/ImageField.vue'
import FileField from '@admin/base/fields/FileField.vue'

import TextFilter from '@admin/base/filters/TextFilter.vue'
import SelectFilter from '@admin/base/filters/SelectFilter.vue'
import BooleanFilter from '@admin/base/filters/BooleanFilter.vue'
import ReferenceFilter from '@admin/base/filters/ReferenceFilter.vue'
import DateFilter from '@admin/base/filters/DateFilter.vue'

import draggable from 'vuedraggable'

import { App } from 'vue'

export default {
  install: (app: App): void => {
    app.component('TextField', TextField)
    app.component('EmailField', EmailField)
    app.component('BooleanField', BooleanField)
    app.component('SwitchField', SwitchField)
    app.component('SelectField', SelectField)
    app.component('DateField', DateField)
    app.component('ReferenceField', ReferenceField)
    app.component('ImageField', ImageField)
    app.component('FileField', FileField)

    app.component('TextFilter', TextFilter)
    app.component('SelectFilter', SelectFilter)
    app.component('BooleanFilter', BooleanFilter)
    app.component('ReferenceFilter', ReferenceFilter)
    app.component('DateFilter', DateFilter)

    app.component('Draggable', draggable)
  },
}
