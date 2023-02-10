export const convertToClientTz = (time, format = 'DD/MM/YYYY HH:mm:ss') => moment.utc(time).tz(moment.tz.guess()).format(format);
export const convertToUtcTz = (time, format = 'YYYY-MM-DDTHH:mm') => moment.tz(time, format, moment.tz.guess()).utc().format(format);
