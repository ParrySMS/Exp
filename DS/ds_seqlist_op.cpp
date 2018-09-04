#include <iostream>
#include <stdio.h>
#include <cstring>

using namespace std;

#define ok 0
#define error -1


class SeqList {
	private:
		int *list;
		int maxsize;
		int size;

	public:
		SeqList();
		~SeqList();
		int list_insert(int i,int item);
		int list_del(int i);
		int list_get(int i);
		void list_show(int res);

};

SeqList::SeqList() {
	maxsize = 1000;
	size = 0;
	list = new int[maxsize];
}

SeqList::~SeqList() {
	delete []list;

}

int SeqList::list_insert(int i,int item) {
	int ar [1000];
	int index;

	//init
	if(size == 0) {
		list[0]=item;
		size++;
	} else if(i>size+1 || i<=0) {
		return error;
	} else {
		//normal
		if(i==1) { // first
			ar[i-1]=item;
			for(index = 0; index<size; index++) {
				ar[index+1]=list[index];
			}
			memcpy(list,ar,sizeof(ar));
			size++;

		} else if(i==size+1) { //end
			list[i-1]=item;
			size++;

		} else { //middle
			for(index = 0; index<i-1; index++) {
				ar[index]=list[index];
			}

			ar[i-1]=item;

			for(index = i-1; index<size; index++) {
				ar[index+1]=list[index];
			}

			memcpy(list,ar,sizeof(ar));
			size++;
		}
	}

	return ok;

}

void SeqList::list_show(int res) {

	if(res == ok) {

		cout << size << " ";

		int i;
		for(i=0; i<size; i++) {
			if(i!=size) {
				cout << list[i]<< " ";
			} else {
				cout << list[i] << endl;
			}
		}
	} else {
		cout << "error";
	}

	cout << '\n';
}

int SeqList::list_del(int i) {
	int index;

	if(i<=0||i>size) {
		return error;
	}


	if(i==size) {
		size--;
	} else {
		i=i-1;//turn index

		for(index = i; index < size-1 ; index++) {
			list[index]=list[index+1];
		}
		size--;
	}

	return ok;

}

int SeqList::list_get(int i) {
	if(i<=0||i>size) {
		cout << "error" << endl;
		return error;
	} else {
		return list[i-1];
	}
}

//main

int main() {
	int num,i,index,data,res;
	SeqList sq;

	//init insert
	scanf("%d",&num);
	for(i=1; i<num+1; i++) {
		scanf(" %d",&data);
		res = sq.list_insert(i,data);
	}
	sq.list_show(res);

	//serial  insert
	scanf("%d %d",&index,&num);
	for(i=1; i<num+1; i++,index++) {
		scanf(" %d",&data);
		res = sq.list_insert(index,data);
		if(res==error) {
			break;
		}

	}
	sq.list_show(res);

	//serial delete
	scanf("%d %d",&index,&num);
	for(i=0; i<num; i++) {
		res = sq.list_del(index);
		if(res == error) {
			break;
		}
	}
	sq.list_show(res);


	return 0 ;
}
