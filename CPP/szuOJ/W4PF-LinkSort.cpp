#include<iostream>
#include<stdio.h>
using namespace std;


#define ok 0
#define error -1

class ListNode {
	public:
		int data;
		ListNode *next;
		ListNode() {
			next = NULL;
		}
};

class LinkList {
	public:
		ListNode *head;
		int len;
		LinkList();
		~LinkList();
		ListNode * last_index(int i);//i-1
//		int get(int i);
		int insert(int i ,int item);
//		int del(int i);
		void show(int res);
		void sort() ;

};

LinkList::LinkList() {
	head = new ListNode();
	len = 0;
}


LinkList::~LinkList() {
	ListNode *p,*q;
	p = head;
	while(p!=NULL) {
		q=p;
		p=p->next;
		delete q;
	}
	len = 0;
	head = NULL;
}


int LinkList::insert(int i ,int item) {
	ListNode *p,*q;
	if(i<=0||i>len+1) {
		return error;
	}

	q = new ListNode();

	p = last_index(i);//i-1

	q->next = p->next;
	q->data = item;
	p->next = q;
	len++;

	return ok;
}


ListNode * LinkList::last_index(int i) {
	int index;
	ListNode *p;
	p = head;

	for(index=1; index<i; index++) {
		p=p->next;
		if(p==NULL) {
			break;
		}
	}
	return (p)?p:NULL;
}

void LinkList::sort() {

	int index,times = len -1,t;
	ListNode *p,*next;

	for(times = 0; times<= len -1; times++) {
		p = head->next;
		for(index=0; index<len-times-1; index++) {
			next=p->next;
			//swap
			if(p->data > next->data) {
				t = p->data;
				p->data = next->data;
				next->data = t;
			}

			p=p->next;
			if(p==NULL) {

				break;
			}
		}
	}

}



void LinkList::show(int res = ok) {
	if(res == error) {
		cout << "error";
	} else {

		ListNode *p;
		p = head->next;
		while(p!=NULL) {
//			cout << "p:"<< p <<endl;
			cout<< p->data << ' ';
			p=p->next;
		}
	}
	cout<<endl;
}





int main() {

	int num,i,data;

	//init insert
	LinkList sll;
	cin>>num;
	for(i=1; i<num+1; i++) {
		cin>>data;
		sll.insert(i,data);
	}

	sll.sort();
	sll.show();

	return 0;
}
