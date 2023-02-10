const { query } = require('../query')

window.readAllNotifications = () => {
    query('#read-all-form').submit()
}
