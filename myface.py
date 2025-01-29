import face_recognition
import cv2
import numpy as np
import sqlite3
import random
from datetime import datetime
conn =sqlite3.connect('face.db')
c =  conn.cursor()

def namep(name):
#    c.execute("SELECT * FROM userdetails WHERE name = :name",{'name':name})
     c.execute("SELECT * FROM userdetails ")
     print(c.fetchall())  
   
def isid(id):
    index = False
    for ap in activepeople:
         if(ap==id):
            index = True
    return index       

def isidinfnames(myid):
    index = False
    for id in face_names:
         if(myid==id):
            index = True
    return index   

                    
                         
exitcamera=False
# c.execute("""CREATE TABLE userdetails(
#     id integer,
#     name text,
#     phone integer,
#     visits integer,
#     photo text
# )""")
# c.execute("""CREATE TABLE userbrands(
#     id integer,
#     brandname text,
#     phone integer,
#     date integer,
#     billid integer
# )""")
# c.execute("""CREATE TABLE uservalue(
#     id integer,
#     amount integer,
#     date integer,
#     billid integer
# )""")
# c.execute("INSERT INTO face VALUES('1','uzair','10000','3')")
# conn.commit()
# c.execute("SELECT * FROM face WHERE name='uzair'")
# print(c.fetchall())

def knowing(path,id):
    #  print(path)
     knwn_image = face_recognition.load_image_file(path)
     knwn_face_encoding = face_recognition.face_encodings(knwn_image)[0]
     known_face_encodings.append(knwn_face_encoding)
     known_face_names.append(path)
     known_face_ids.append(id)
     date=datetime.today()
     c.execute("INSERT INTO userdetails (id,username,visits,mobileno,emailid,photo,joined_at) VALUES(?,'unknown','0','','',?,?)",(id,path,date))
     conn.commit()
# def snap():
#     detector=cv2.CascadeClassifier('haarcascade_frontalface_default.xml')
#     faces = detector.detectMultiScale(img, 1.3, 5)
#     cv2.imwrite(+"/User."+Id +'.'+ str(sampleNum) + ".jpg", img[y-70:y+h+70,x-70:x+w+70])
       
video_capture = cv2.VideoCapture(0)

# Load a sample picture and learn how to recognize it.
obama_image = face_recognition.load_image_file("jaq.jpg")
obama_face_encoding = face_recognition.face_encodings(obama_image)[0]

# Load a second sample picture and learn how to recognize it.
biden_image = face_recognition.load_image_file("4.jpg")
biden_face_encoding = face_recognition.face_encodings(biden_image)[0]

# Create arrays of known face encodings and their names
known_face_encodings = [
    obama_face_encoding,
    biden_face_encoding
]
known_face_names = [
        "justin",
        "selena"
]
known_face_ids=[
64646,
57675
]
# for encoding in encodings:
c.execute("SELECT photo,username,id FROM userdetails ")
users =c.fetchall()
print(users)  
for user in users:
    new_image = face_recognition.load_image_file(user[0])
    new_face_encoding = face_recognition.face_encodings(new_image)[0]
    known_face_encodings.append(new_face_encoding)
    known_face_names.append(user[1])
    known_face_ids.append(user[2])


camtitle='Enter'
camcolor=(0,255,0)

# Initialize some variables
face_locations = []
face_encodings = []
face_names = []
process_this_frame = True
activepeople=[]
while True:
    # Grab a single frame of video
    ret, frame = video_capture.read()

    # Resize frame of video to 1/4 size for faster face recognition processing
    small_frame = cv2.resize(frame, (0, 0), fx=0.25, fy=0.25)

    # Convert the image from BGR color (which OpenCV uses) to RGB color (which face_recognition uses)
    rgb_small_frame = small_frame[:, :, ::-1]

    # Only process every other frame of video to save time
    if process_this_frame:
        # Find all the faces and face encodings in the current frame of video
        face_locations = face_recognition.face_locations(rgb_small_frame)
        face_encodings = face_recognition.face_encodings(rgb_small_frame, face_locations)
        face_names=[]
        for face_encoding in face_encodings:
            # See if the face is a match for the known face(s)
            matches = face_recognition.compare_faces(known_face_encodings, face_encoding)
            name = "Unknown"
            myid=0

            # # If a match was found in known_face_encodings, just use the first one.
            # if True in matches:
            #     first_match_index = matches.index(True)
            #     name = known_face_names[first_match_index]

            # Or instead, use the known face with the smallest distance to the new face
            face_distances = face_recognition.face_distance(known_face_encodings, face_encoding)
            
            best_match_index = np.argmin(face_distances)

            if matches[best_match_index]:
                name = known_face_names[best_match_index]
                myid = known_face_ids[best_match_index]

                #detail from sql
                # namep(name)

                if(isid(myid)==False):
                    if(exitcamera==False):
                          activepeople.append(myid)
                          c.execute("UPDATE userdetails SET status=1, visits=visits+1 WHERE id=:myid",{'myid':myid})
                          conn.commit()
                    print("active_people=")
                    print(activepeople)
                else:
                    if(exitcamera==True):
                          activepeople.remove(myid)
                          c.execute("UPDATE userdetails SET status=0 WHERE id=:myid",{'myid':myid})
                          conn.commit()
                    print(name+" is active")
            else:
                for (top, right, bottom, left) in face_locations:
                    top *= 4
                    right *= 4
                    bottom *= 4
                    left *= 4
                    print(top,right,bottom,left)
                    id = random.randint(100,100000)+left
                    # Scale back up face locations since the frame we detected in was scaled to 1/4 size
                    # cv2.rectangle(frame, (left-20, top-20), (right+20, bottom+20), (0, 255, 0), 2)
                    newpath=str(id)+"unknown.jpg"
                    valim=False
                    valim= cv2.imwrite(newpath, frame[top-60:bottom+60,left-60:right+60])
                print(activepeople) 
                name="unknown detected"
                print(name)
             
                if(valim==True):
                   knowing(newpath,id)
                   myid=id

           

            if(isidinfnames(str(myid))==False):   
                face_names.append(str(myid))


    process_this_frame = not process_this_frame


    # Display the results
    for (top, right, bottom, left), name in zip(face_locations, face_names):
        # Scale back up face locations since the frame we detected in was scaled to 1/4 size
        top *= 4
        right *= 4
        bottom *= 4
        left *= 4

        # Draw a box around the face
        cv2.rectangle(frame, (left, top), (right, bottom), (255, 0, 0), 2)
        # Draw a label with a name below the face
        cv2.rectangle(frame, (left, bottom - 35), (right, bottom), (255, 0, 0), cv2.FILLED)
        font = cv2.FONT_HERSHEY_DUPLEX
        cv2.putText(frame, name, (left + 6, bottom - 6), font, 1.0, (255, 255, 255), 1)



    cv2.rectangle(frame, (255, 15), (340, 50), camcolor, cv2.FILLED)
    font = cv2.FONT_HERSHEY_DUPLEX
    cv2.putText(frame, camtitle, (265, 45), font, 0.8, (255,255,255), 2)

    # Display the resulting image
    cv2.imshow('Camera Monitoring Module', frame)



    # Hit 'q' on the keyboard to quit!
    if cv2.waitKey(50) & 0xFF == ord('q'):
         for name in activepeople:
                    namep(name)
                    conn.close()
         break
    elif cv2.waitKey(50) & 0xFF == ord('r'):
         if(exitcamera==False):
                exitcamera=True
                camtitle='Exit'
                camcolor=(0, 0, 255)
         else:
                exitcamera=False       
                camtitle='Enter'
                camcolor=(0,255,0)

         print('changing camera...exit:')
         print(exitcamera)
         
         
# Release handle to the webcam
video_capture.release()
cv2.destroyAllWindows()