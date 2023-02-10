const scanner = require('sonarqube-scanner');

require('dotenv').config();

const { SONAR_SERVER, SONAR_TOKEN, SONAR_ACCOUNT, SONAR_PASSWORD } = process.env;

const scannerConfig = {
    serverUrl: 'http://localhost:9000',
    token: SONAR_TOKEN,
    options: {
        'sonar.projectName': 'shilin:backend',
        'sonar.projectDescription': 'shilin Backend',
        'sonar.sources': '.',
        // 'sonar.tests': 'specs'
    }
}

scannerConfig.serverUrl = SONAR_SERVER ?? 'http://localhost:9000'
scannerConfig.token = SONAR_TOKEN ?? null

if (SONAR_ACCOUNT) {
    scannerConfig.options['sonar.login'] = SONAR_ACCOUNT
}

if (SONAR_PASSWORD) {
    scannerConfig.options['sonar.password'] = SONAR_PASSWORD
}

scanner(scannerConfig)
