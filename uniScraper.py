from selenium import webdriver # type: ignore
from selenium.webdriver.chrome.options import Options # type: ignore
from selenium.webdriver.common.by import By # type: ignore
from selenium.webdriver.common.action_chains import ActionChains # type: ignore
from selenium.webdriver.support.ui import WebDriverWait # type: ignore
from selenium.webdriver.support import expected_conditions as EC # type: ignore
from selenium.common.exceptions import TimeoutException # type: ignore
from selenium.common.exceptions import WebDriverException # type: ignore
from time import sleep

def create_driver(profile_path=None):
    options = Options()
    options.add_argument("--disable-blink-features=AutomationControlled")
    options.add_argument("--no-sandbox")
    options.add_argument("--disable-dev-shm-usage")
    options.add_argument("--disable-gpu")
    options.add_argument("--disable-infobars")
    options.add_argument("--disable-extensions")
    options.add_argument("--disable-popup-blocking")
    options.add_argument("--disable-logging")
    options.add_argument("--log-level=3")
    options.add_experimental_option("excludeSwitches", ["enable-automation"])
    options.add_experimental_option('useAutomationExtension', False)

    if profile_path:
        options.add_argument(f"user-data-dir={profile_path}")

    driver = webdriver.Chrome(options=options)
    driver.execute_cdp_cmd("Page.addScriptToEvaluateOnNewDocument", {
        "source": """
        Object.defineProperty(navigator, 'webdriver', {
            get: () => undefined
        })
        """
    })
    return driver

def wait_for_element(driver, by, value, timeout=10):
    return WebDriverWait(driver, timeout).until(EC.presence_of_element_located((by, value)))

def click_button(driver, by, value):
    button = wait_for_element(driver, by, value)
    button.click()

def find_elements_viaCSS(css_selector):
    wait_for_element(driver, By.CSS_SELECTOR, css_selector)
    return driver.find_elements(By.CSS_SELECTOR, css_selector)

def input_text(driver, by, value, text):
    input_field = wait_for_element(driver, by, value)
    input_field.clear()
    input_field.send_keys(text)

def hover_over_element(driver, by, value):
    element = wait_for_element(driver, by, value)
    ActionChains(driver).move_to_element(element).perform()

def close_driver(driver):
    driver.quit()

def scroll_to_element(driver, by, value):
    element = wait_for_element(driver, by, value)
    driver.execute_script("arguments[0].scrollIntoView(true);", element)

def find_element_with_timeout(css_selector, timeout=10):
    try:
        element = WebDriverWait(driver, timeout).until(EC.presence_of_element_located((By.CSS_SELECTOR, css_selector)))
        return element
    except TimeoutException:
        return False



if __name__ == "__main__":
    profile_path = "/Users/mac/Library/Application Support/Google/Chrome/Profile 5"
    driver = create_driver(profile_path=profile_path)
    try:
        driver.get("https://beykentunivtercihrobotu.k12net.com/JS/WebParts/Default/Default.aspx")
    except WebDriverException as e:
        if "ERR_INTERNET_DISCONNECTED" in str(e):
            print("Error: No internet connection. Please check your network settings.")
        else:
            print(f"An unexpected error occurred: {e}")
    else:

        totalSQLInsert = "INSERT INTO `universiteler` (`universite`, `fakulte`, `sehir`, `unituru`, `ucret`, `siralamalar`, `kontenjanlar`, `unikodu`) VALUES \n"

        input("waiting for filters...")
        wait_for_element(driver, By.CSS_SELECTOR, "tbody#mainTableBody > tr")
        allOfTheTableRows = driver.find_elements(By.CSS_SELECTOR, "tbody#mainTableBody > tr")
        for row in allOfTheTableRows:
            print("=====================================")
            columns = row.find_elements(By.CSS_SELECTOR, "td")

            universite = columns[3].find_element(By.CSS_SELECTOR, "a").text
            fakulte = columns[3].find_element(By.CSS_SELECTOR, "span").text
            print(f"universite: {universite}")
            print(f"fakulte: {fakulte}")

            sehir = columns[5].find_element(By.CSS_SELECTOR, "span").text
            print(f"sehir: {sehir}")

            unituru = columns[7].find_element(By.CSS_SELECTOR, "div div:nth-child(2)").text
            print(f"unituru: {unituru}")

            ucret = columns[8].find_element(By.CSS_SELECTOR, "span").text
            if ucret.replace(" ","").replace("\n","") == "":
                ucret = "Ücretsiz"
            print(f"ucret: {ucret}")



            puanlarDivleri = columns[9].find_elements(By.CSS_SELECTOR, "div")[0].find_elements(By.CSS_SELECTOR, "div")[1].find_elements(By.CSS_SELECTOR, "div")

            #Puanlar = 23,22,21,20
            puanlar = ""
            for puanDivi in puanlarDivleri:
                puan = puanDivi.text.replace("&nbsp;", "").replace(" ", "").replace("\n", "")
                if puan == "----" or puan == "":
                    puan = "NULL"
                puanlar += puan + "|"
            puanlar = puanlar[:-1]
            print(f"puanlar: {puanlar}")


            siralamaDivleri = columns[10].find_elements(By.CSS_SELECTOR, "div")[0].find_elements(By.CSS_SELECTOR, "div")[1].find_elements(By.CSS_SELECTOR, "div")

            siralamalar = ""
            for siralamaDivi in siralamaDivleri:
                siralama = siralamaDivi.text.replace("&nbsp;", "").replace(" ", "").replace("\n", "")
                if siralama == "----" or siralama == "":
                    siralama = "NULL"
                siralamalar += siralama + "|"
            siralamalar = siralamalar[:-1]
            print(f"siralamalar: {siralamalar}")


            kontenjanDivleri = columns[11].find_elements(By.CSS_SELECTOR, "div.d-flex.flex-column div")
            
            kontenjanlar = ""
            for kontenjanDivi in kontenjanDivleri:
                kontenjan = kontenjanDivi.text.replace("&nbsp;", "").replace(" ", "").replace("\n", "")
                if kontenjan == "----" or kontenjan == "":
                    kontenjan = "NULL"
                kontenjanlar += kontenjan + "|"
            kontenjanlar = kontenjanlar[:-1]
            kontenjanlar = kontenjanlar[kontenjanlar.find("|") + 1:]

            print(f"kontenjanlar: {kontenjanlar}")

            uniKodu = columns[2].find_element(By.CSS_SELECTOR, "a").text
            print(f"uniKodu: {uniKodu}")
            print(f"Akademisyen Listesi: https://yokatlas.yok.gov.tr/lisans.php?y={uniKodu}")

            totalSQLInsert += f"('{universite}', '{fakulte}', '{sehir}', '{unituru}', '{ucret}', '{siralamalar}', '{kontenjanlar}', '{uniKodu}'),\n"


        totalSQLInsert = totalSQLInsert[:-2] + ";"
        print(totalSQLInsert)
            


    close_driver(driver)
