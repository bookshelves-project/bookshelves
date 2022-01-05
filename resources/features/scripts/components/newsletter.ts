import axios from 'axios'

const newsletter = () =>
  ({
    success: false,
    failed: false,
    submitting: false,
    email: null,
    actionUrl() {
      return (this.$el as HTMLElement).getAttribute('action')
    },
    async submit() {
      this.success = false
      this.submitting = true

      try {
        await axios.post(this.actionUrl(), {
          email: this.email,
        })
        this.success = true
        this.email = null
      } catch (e) {
        this.failed = true
      } finally {
        this.submitting = false
      }
    },
  } as any)

export default newsletter
