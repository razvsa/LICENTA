from google.cloud import vision_v1
from datetime import datetime
import re,sys
client = vision_v1.ImageAnnotatorClient.from_service_account_json('D:\\xampp\\htdocs\\eJobs\\frontend\\web\\python\\API.json')
import io
img=sys.argv[1]
with io.open(img, 'rb') as image_file:
    content = image_file.read()
image = vision_v1.Image(content=content)
features = [vision_v1.Feature(type_=vision_v1.Feature.Type.DOCUMENT_TEXT_DETECTION)]
request = vision_v1.AnnotateImageRequest(image=image, features=features)
response = client.annotate_image(request)
text_annotations = response.text_annotations
detected_text = text_annotations[0].description

###################################################################
'''
0- Documnetul nu este o carte de identitate
1- Eroare de validare
2- Expirat
3- Valid
'''
###################################################################

with open("nume_fisier.txt", "w", encoding="utf-8") as f:
    print(text_annotations[0].description, file=f)

#verificare existenta carte de identitate
if not "CARTE DE IDENTITATE" in detected_text:
    #print("Documnetul nu este o carte de identitate")
    print(0)
    sys.exit()

#extragere serie
regex_pattern_serie = r"SERIA .{2} NR \d{6}"
matches = re.findall(regex_pattern_serie, detected_text)
if matches:
    extracted_sequence = matches[0]
    split=extracted_sequence.split()
    serie_completa=split[1]+split[3]
else:
    #print("Secvența SERIE nu a fost găsită.")
    print(1)
    sys.exit()

#verificare cnp
regex_pattern = r"CNP .*" 
matches = re.findall(regex_pattern, detected_text, re.MULTILINE)
if matches:
    cnp_line = matches[0]
    regex_pattern = r"\d"  
    matches = re.findall(regex_pattern, cnp_line)
    cnp_digits = [int(match) for match in matches]
    if len(cnp_digits)!=13:
        print(1)
        #print("Cnp invalid")
        sys.exit()
    else:
        sum=0
        sir=[2,7,9,1,4,6,3,5,8,2,7,9]
        for i in range(12):
            sum=sum+sir[i]*cnp_digits[i]
        if sum%11==cnp_digits[12] or (sum%11==10 and cnp_digits[12]==0):
            pass
            #print("CNP VALID")
        else:
            #print("CNP control invalid")
            print(1)
            sys.exit()        

else:
    #print("Nu s-a găsit nicio linie care începe cu 'CNP'.")
    print(1)
    sys.exit()


#verificare data expirare
regex_pattern = r"\d{2}\.\d{2}\.\d{2}-\d{2}\.\d{2}\.\d{4}"
matches = re.findall(regex_pattern, detected_text)
if len(matches)>0:
    data = matches[0]
    date_range = data.split('-')
    start_date = date_range[0].split('.')
    end_date = date_range[1].split('.')
    end=end_date[0]+'/'+end_date[1]+'/'+end_date[2]
    data = datetime.strptime(end, "%d/%m/%Y")
    data_curenta = datetime.now()
    if data < data_curenta:
        print(2)
        sys.exit()

    
else :
    #print("Date de expirare negasita")
    print(1)
    sys.exit()


greutate=[7,3,1,7,3,1,7,3,1,7,3,1,7,3,1,7,3,1,7,3,1,7,3,1,7,3,1,7,3,1,7,3,1,7,3,1]
#verificare string optic 1
regex_pattern = r"IDROU.*"
matches = re.findall(regex_pattern, detected_text)

if matches:
    sequence = matches
else:
    print(1)
    #print("Nu s-a găsit primul sir optic.")
    sys.exit()

#verificare string optic 2
  
regex_pattern = serie_completa + r".*"
matches = re.findall(regex_pattern, detected_text)
if matches:
    sequence = matches
    vector = []
    for subsir in sequence:
        subsir=subsir.replace(" ","")
        for caracter in subsir:
            if caracter.isdigit():
                valoare = int(caracter)
            elif caracter.isalpha():
                valoare = ord(caracter.upper()) - ord('A') + 10
            elif caracter=='<':
                valoare = 0 

            vector.append(valoare)

    sum=0
    for i in range(9):
        sum=sum+greutate[i]*vector[i]
    if(sum%10==vector[9]):
        #print("Serie buletin valida")
        pass
    else:
        print(1)
        #print("seria de buletin nu este valida")
        sys.exit()
    
    if vector[10]!=27 and vector[11]!=24 and vector[12]!=30:
        print(1)
        #print("Eroare validare Optica")
        sys.exit()
    
    sum=0
    for i in range(13,19):
        sum=sum+greutate[i-13]*vector[i]
    if(sum%10==vector[19]):
        pass
        #print("Data nastere buletin valida")
    else:
        print(1)
        #print("Data nastere buletin nu este valida")
        sys.exit()

    sum=0
    for i in range(21,27):
        sum=sum+greutate[i-21]*vector[i]
    if(sum%10==vector[27]):
        pass
        #print("Data expirare buletin valida")
    else:
        print(1)
        #print("Data expirare buletin nu este valida")
        sys.exit()

    
    index=0
    sum=0
    for i in range(10):
        sum=sum+vector[i]*greutate[index]
        index=index+1
    for i in range(13,20):
        sum=sum+vector[i]*greutate[index]
        index=index+1
    for i in range(21,35):
        sum=sum+vector[i]*greutate[index]
        index=index+1
    if(sum%10==vector[35]):
        pass
        #print("Citire optica buletin valida")
    else:
        #print("SUma este",sum)
        #print("Citire optica buletin nu este valida")
        print(1)
        sys.exit()
        
else:
    print(1)
    #print("Nu s-a găsit al doilea sir optic.")
    sys.exit()

print(3)


