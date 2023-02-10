import { decodeNumber, encodeNumber } from './format-number.js'

export const mapNumberEncodeDisplay = fields => fields.reduce(
    (pre, cur) => {
        pre[cur + 'Display'] = {
            get() {
                return encodeNumber(this[cur])
            },
            set(val) {
                this[cur] = decodeNumber(val)
            }
        }

        return pre;
    },
    {}
)
