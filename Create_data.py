from random import shuffle
import numpy as np

def unseen(list1, list2):
    cur = 0
    cur1 = 0
    list = []
    while cur1<len(list1):
        if cur<len(list2) and list1[cur1]>=list2[cur]:
            cur = cur + 1
            continue
        list.append(list1[cur1])
        cur1 = cur1 + 1

    shuffle(list)
    return list[0:100]

def create_data():
    path = 'Data/ratings.dat'
    movie = 'Data/movies.dat'
    ratinglist = []
    testlist = []
    templist = []
    negatives = []
    movies = []
    print("read movie")
    with open(movie, "r") as f:
        line = f.readline()
        while line != None and line != "":
            arr = line.split("::")
            movies.append(int(arr[0]))
            line = f.readline()
    print("read movie done")
    with open(path, "r") as f:
        line = f.readline()
        cur = 1
        while line != None and line != "":
            arr = line.split("::")
            user, item, rating = int(arr[0]), int(arr[1]), float(arr[2])
            if cur%10==0:
                templist.append(item)
            if user!=cur:
                temp = ratinglist.pop()
                if cur%10==0:
                    testlist.append(temp)
                    negatives.append(unseen(movies,templist))
                    templist = []
                cur = cur + 1
            ratinglist.append([user, item, rating])
            line = f.readline()
            if user == 6000:
                break
    print("calc done")
    # temp = np.asarray(negatives)
    # np.savetxt("Data/rating.negative", temp, delimiter="\t")
    # temp1 = np.asarray(ratinglist)
    # np.savetxt("Data/rating.train", temp1, delimiter="\t")
    # temp2 = np.asarray(testlist)
    # np.savetxt("Data/rating.test", temp2, delimiter="\t")
    with open("Data/10m.train.rating", "w") as f:
        for i in range(len(ratinglist)):
            f.write(str(ratinglist[i][0]))
            f.write("\t")
            f.write(str(ratinglist[i][1]))
            f.write("\t")
            f.write(str(ratinglist[i][2]))
            f.write("\n")

    with open("Data/10m.test.rating", "w") as f:
        for i in range(len(testlist)):
            f.write(str(testlist[i][0]))
            f.write("\t")
            f.write(str(testlist[i][1]))
            f.write("\n")

    with open("Data/10m.test.negative", "w") as f:
        for i in range(len(negatives)):
            f.write(str((i+1)*10))
            f.write("\t")
            for j in range(len(negatives[i])-1):
                f.write(str(negatives[i][j]))
                f.write("\t")
            f.write(str(negatives[i][len(negatives[i])-1]))
            f.write('\n')

if __name__ == '__main__':
    create_data()