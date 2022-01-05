import { parse as createFromFormat, isAfter, differenceInDays } from 'date-fns'
import axios from 'axios'

const formReservation = (
  lots: [],
  housingType: string,
  basePrice: number,
  oldPersonOptionPrice: number,
  additionalPersonPrice: number
) =>
  ({
    lots,
    housingType,
    basePrice,
    nbDays: 0,
    oldPersonOptionPrice,
    additionalPersonPrice,
    periods: [],
    submitting: false,
    errors: null,
    success: null,
    form: {
      housing_type: housingType,
      nb_person: 1,
      date_in: null,
      date_out: null,
      old_person_option: false,
      prospect_status: null,
      gender: null,
      lastname: null,
      firstname: null,
      email: null,
      phone: null,
      message: null,
      partner_code: null,
      optin: false,
    },

    init() {
      this.makePeriods()
    },

    makePeriods() {
      this.lots.forEach((lot) => {
        this.periods.push({
          start: new Date(lot.date_in),
          end: new Date(lot.date_out),
        })
      })
    },

    onChangeDatepicker(value) {
      this.form[value.detail.name] = value.detail.value
    },
    addPerson() {
      if (this.housingType !== 't1' && this.form.nb_person < 2) {
        this.form.nb_person++
      }
    },
    removePerson() {
      if (this.housingType !== 't1' && this.form.nb_person > 0) {
        this.form.nb_person--
      }
    },
    isValidForm() {
      // Min 1 personne
      if (this.form.nb_person <= 0) {
        return false
      }

      // Dates définies
      if (!this.form.date_in || !this.form.date_out) {
        return false
      }

      // Date d'arrivée < Date de départ
      const dateIn = createFromFormat(
        this.form.date_in,
        'yyyy-MM-dd',
        new Date()
      )
      const dateOut = createFromFormat(
        this.form.date_out,
        'yyyy-MM-dd',
        new Date()
      )
      if (!isAfter(dateOut, dateIn)) {
        return false
      }

      return true
    },
    get total() {
      if (
        !(this.form.date_in && this.form.date_out) ||
        this.form.nb_person === 0
      ) {
        return '-'
      }

      const dateIn = createFromFormat(
        this.form.date_in,
        'yyyy-MM-dd',
        new Date()
      )
      const dateOut = createFromFormat(
        this.form.date_out,
        'yyyy-MM-dd',
        new Date()
      )

      this.nbDays = differenceInDays(dateOut, dateIn)

      let result = parseInt(this.basePrice) * this.nbDays

      if (this.form.nb_person > 1) {
        const additionalPersons = this.form.nb_person - 1
        result += additionalPersons * this.nbDays * this.additionalPersonPrice
      }

      if (this.form.old_person_option) {
        result += this.oldPersonOptionPrice * this.form.nb_person
      }

      return result + ' €'
    },
    get disableSubmit() {
      return !this.isValidForm() || this.submitting
    },

    actionUrl() {
      return (this.$refs.form as HTMLElement).getAttribute('action')
    },
    async onSubmit() {
      this.errors = null
      this.success = null
      this.submitting = true

      try {
        const { data } = await axios.post(this.actionUrl(), this.form)
        this.success = data
        this.form = {
          housing_type: housingType,
          nb_person: 1,
          date_in: null,
          date_out: null,
          old_person_option: false,
          lastname: null,
          firstname: null,
          email: null,
          phone: null,
          message: null,
          partner_code: null,
          optin: false,
        }
      } catch (e) {
        if (axios.isAxiosError(e) && e.response) {
          this.errors = e.response.data
          return
        }
      } finally {
        this.submitting = false
      }
    },
  } as any)

export default formReservation
