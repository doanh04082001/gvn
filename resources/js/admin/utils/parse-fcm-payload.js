export const parseFcmPayload = ({ payload }) => payload ? JSON.parse(payload) : null
