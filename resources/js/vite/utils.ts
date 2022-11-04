import { loadEnv } from 'vite'
import _ from 'lodash'

// Utilities (incase we want to replace lodash's with our own later)

export const _env = (key: string, fallback: any = null, mode: string|null|undefined): string|null|boolean => {

  const env = loadEnv(mode, process.cwd(), ''),
        value = env[key] || fallback

  if (['true', 'false'].includes(value)) {
    return value === 'true'
  }

  if (value === 'null') {
    return null
  }

  return value
}

export const _envIs = (environments: Array<string>, mode: string|undefined): boolean => (
  environments.includes(
    String(
      _env('APP_ENV', null, mode)
    ).toLowerCase()
  )
)

export const _set = (object: object, path: string, value: any): object => (
  _.set(object, path, value)
)

export const _has = (object: object, path: string, ...paths: Array<string>): boolean => (
  ! ! paths.push(path) && paths.every(pth => _.has(object, pth))
)

export const _merge = (object: object, path: string, merge: object|Array<any>): object => {
  const value = _.get(object, path, null)
  
  if (value === null) {
    return _set(object, path, merge)
  }
  
  if (Array.isArray(value)) {
    return _set(object, path, value.concat(merge))
  }

  return _set(object, path, {
    ...value,
    ...merge
  })
}

export const _cascade = (object: object, fallback: any, ...paths: Array<string>): any => {
  const hasPaths = paths.filter(path => _has(object, path))

  if (hasPaths.length === 0) {
    return fallback
  }

  return hasPaths[0]
}

const themeColor = "\x1b[35m",
      nl = "\n",
      reset =  "\x1b[0m"

const STYLE = {
  reset,
  start:     `${nl}${reset}${themeColor}`,
  theme:     `${reset}${themeColor}`,
  eol:       `${nl}  ${reset}${themeColor}`,

  bright:    "\x1b[1m",
  dim:       "\x1b[2m",
  underline: "\x1b[4m",
  blink:     "\x1b[5m",
  reverse:   "\x1b[7m",
  hidden:    "\x1b[8m",
  black:     "\x1b[30m",

  magenta:   themeColor,
  red:       "\x1b[31m",
  green:     "\x1b[32m",
  yellow:    "\x1b[33m",
  blue:      "\x1b[34m",
  cyan:      "\x1b[36m",
  white:     "\x1b[37m",
  bgBlack:   "\x1b[40m",
  bgRed:     "\x1b[41m",
  bgGreen:   "\x1b[42m",
  bgYellow:  "\x1b[43m",
  bgBlue:    "\x1b[44m",
  bgMagenta: "\x1b[45m",
  bgCyan:    "\x1b[46m",
  bgWhite:   "\x1b[47m",
}

export const _log = (...messages: Array<string>): void => (
  console.log(STYLE.start, (
    messages
      .map(m => {
        Object.entries(STYLE).map(([name, code]) => (
          m = m.replace(`{${name}}`, code)
        ))
        return m
      })
      .join(STYLE.eol)
  ), STYLE.reset)
)

export const _json = (subject: any): string => JSON.stringify(subject)

export const _dejson = (json: string): string => JSON.parse(json)