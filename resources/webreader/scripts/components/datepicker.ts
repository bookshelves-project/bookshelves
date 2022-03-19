import {
  format as dateFormat,
  isToday,
  getDaysInMonth,
  getYear,
  getMonth,
  parse as createFromFormat,
  isAfter,
  isBefore,
} from 'date-fns'

const datepicker = (
  inputName: string,
  format: string,
  availableDates: string[],
  defaultDate: string,
  minDate: string,
  maxDate: string
) =>
  ({
    inputName,
    defaultDate,
    minDate,
    maxDate,
    format, // Format date-fns => https://date-fns.org/
    showDatepicker: false,
    datepickerValue: '',
    month: '',
    year: '',
    displayedDays: [],
    blankdays: [],
    availableDates,
    today: new Date(),
    months: [
      'Janvier',
      'Février',
      'Mars',
      'Avril',
      'Mai',
      'Juin',
      'Juillet',
      'Août',
      'Septembre',
      'Octobre',
      'Novembre',
      'Decembre',
    ],
    days: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],

    init() {
      this.initDate()

      this.$watch('showDatepicker', (value) => {
        if (value) {
          this.onOpenDatepicker()
          this.defineDays()
        } else {
          this.displayedDays = []
          this.blankdays = []
        }
      })
    },

    // Méthode d'initialisation de la date sélectionnée
    initDate() {
      this.datepickerValue = null

      let date: Date | null = null
      if (this.$refs.date.value) {
        date = createFromFormat(this.$refs.date.value, 'yyyy-MM-dd', new Date())
      } else if (this.defaultDate) {
        date = createFromFormat(this.defaultDate, 'yyyy-MM-dd', new Date())
      }

      if (date) {
        this.datepickerValue = dateFormat(date, this.format)
        this.$refs.date.value = dateFormat(date, 'yyyy-MM-dd')
      }
    },

    // Méthode permettant d'initialiser le mois afficher lors de l'ouverture
    onOpenDatepicker(): void {
      let date: Date | null = null

      if (this.$refs.date.value) {
        date = createFromFormat(this.$refs.date.value, 'yyyy-MM-dd', new Date())
      } else if (this.defaultDate) {
        date = createFromFormat(this.defaultDate, 'yyyy-MM-dd', new Date())
      }

      this.month = this.today.getMonth()
      this.year = this.today.getFullYear()
      if (date) {
        this.month = getMonth(date)
        this.year = getYear(date)
      }
    },

    isToday(day: number): boolean {
      return isToday(new Date(this.year, this.month, day))
    },

    onSelectDate(day: number): void {
      const selectedDate = new Date(this.year, this.month, day)

      this.datepickerValue = dateFormat(selectedDate, this.format)
      this.$refs.date.value = dateFormat(selectedDate, 'yyyy-MM-dd')

      this.showDatepicker = false
      this.$dispatch('datepicker:change', {
        name: this.inputName,
        value: this.$refs.date.value,
      })
    },

    defineDays() {
      const nbDaysInCurrentMonth = getDaysInMonth(
        new Date(this.year, this.month)
      )

      /*
      Récupération du premier jour du mois en cours. Numéro de jour compris entre 0 et 6
      */
      const dayOfWeek = new Date(this.year, this.month).getDay()

      const blankdaysArray: number[] = []
      for (let i = 1; i <= dayOfWeek; i++) {
        blankdaysArray.push(i)
      }

      const daysArray: number[] = []
      for (let i = 1; i <= nbDaysInCurrentMonth; i++) {
        daysArray.push(i)
      }

      this.blankdays = blankdaysArray
      this.displayedDays = daysArray
    },

    prevMonth() {
      if (this.month === 0) {
        this.year = this.year - 1
        this.month = 11
      } else {
        this.month = this.month - 1
      }

      this.defineDays()
    },
    nextMonth() {
      if (this.month === 11) {
        this.year = this.year + 1
        this.month = 0
      } else {
        this.month = this.month + 1
      }
      this.defineDays()
    },

    isAfterMaxDate(date: number): boolean {
      if (!this.maxDate) {
        return false
      }

      const currentDate = new Date(this.year, this.month, date)
      const maxDate = createFromFormat(this.maxDate, 'yyyy-MM-dd', new Date())
      return isAfter(currentDate, maxDate)
    },
    isBeforeMinDate(date: number): boolean {
      if (!this.minDate) {
        return false
      }

      const currentDate = new Date(this.year, this.month, date)
      const minDate = createFromFormat(this.minDate, 'yyyy-MM-dd', new Date())
      return isBefore(currentDate, minDate)
    },
    isSelectedDate(date) {
      if (!this.$refs.date.value) {
        return false
      }

      const currentDate = new Date(this.year, this.month, date)
      const parseSelectedDate = Date.parse(this.$refs.date.value)

      return (
        dateFormat(currentDate, 'yyyy-MM-dd') ===
        dateFormat(parseSelectedDate, 'yyyy-MM-dd')
      )
    },
    isHighlightedDate(date) {
      const currentDate = dateFormat(
        new Date(this.year, this.month, date),
        'yyyy-MM-dd'
      )

      return this.availableDates.indexOf(currentDate) !== -1
    },
    isPastDate(date) {
      return new Date(this.year, this.month, date) < this.today
    },
  } as any)

export default datepicker
