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
		int get(int i);
		int insert(int i ,int item);
		int del(int i);
		void show(int res);

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


void LinkList::show(int res) {
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

int LinkList::del(int i) {
	ListNode *p,*q;

	if(i<=0||i>len) {
		return error;
	}

	p = last_index(i);//i-1
	q = last_index(i+1);

	if(q == NULL) { //end
		p->next = NULL;
	} else { //mid
		p->next = q->next;
		delete q;
	}

	return ok;

}

int LinkList::get(int i) {
	ListNode *p;

	if(i<=0||i>len) {
		return error;
	}

	p = last_index(i+1);

	if(p==NULL) {
		return error;
	}

	return p->data;

}


int main() {

	int num,i,index,data,res;
	int t,ins_num,del_num;

	//init insert
	cin>>t;
	while(t--) {
		LinkList sll;
		cin>>num;
		for(i=1; i<num+1; i++) {
			cin>>data;
			res = sll.insert(i,data);
		}

		sll.show(res);

		cin>>ins_num;
		//normal insert
		for(i=0; i<ins_num; i++) {
			cin>>index>>data;
			res = sll.insert(index+1,data);
			sll.show(res);
		}


		cin>>del_num;
		//delete
		for(i=0; i<del_num; i++) {
			cin>>index;
			res = sll.del(index);
			sll.show(res);
		}


//	//search
//	for(i=0; i<2; i++) {
//		scanf("%d",&index);
//		data = sll.get(index);
//		if(data!=error) {
//			cout << data << endl;
//		} else {
//			cout << "error" << endl;
//		}
//	}

		sll.~LinkList();

	}
	return 0;
}

