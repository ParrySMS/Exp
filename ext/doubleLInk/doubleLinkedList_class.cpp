#include<iostream>
using namespace std;

#define ok 0
#define error -1

class ListNode {
	public:
		int data;
		ListNode *pre;
		ListNode *next;
		ListNode() {
			pre = NULL;
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
		p = p->next;
		//cout<<"p-next:"<<p<<endl;
		if(p == NULL||index == i-1) {
			break;
		}
	}
	return (p)?p:NULL;
}


void LinkList::show(int res) {

	if(res == error) {
		cout<<"error"<<endl;
	} else {
		ListNode *p;
		p = head->next;
		while(p!=NULL) {
//			cout << "p:"<< p <<endl;
			cout<< p->data << ' ';
			p=p->next;
		}

		cout<<endl;
	}
}

int LinkList::insert(int i ,int item) {
	ListNode *p,*new_node;
	if(i<=0||i>len+1) {
		return error;
	}

	new_node = new ListNode();

	p = last_index(i);//i-1

	new_node->next = p->next;
	new_node->data = item;
	new_node->pre = p;

	p->next = new_node;

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

	if(q == NULL || q->next == NULL) { //end
		p->next = NULL;
	} else { //mid
		p->next = q->next;
		q->next->pre = p;
		delete q;
	}

	return ok;

}

int main() {
	int num,i,index,data,res;
	LinkList sll;
	//init insert
	cout<<"input the num of data:";
	cin>>num;

	cout<<"input data:"<<endl;
	for(i=1; i<num+1; i++) {
		cin>>data;
		res = sll.insert(i,data);
	}
	sll.show(res);

	//normal insert

	for(i=0; i<2; i++) {
		cout<<"normal insert:input (index data)"<<endl;
		cin>>index>>data;
		res = sll.insert(index,data);
		sll.show(res);
	}

	//delete
	for(i=0; i<2; i++) {
		cout<<"delete:input (index)"<<endl;
		cin>>index;
		res = sll.del(index);
		sll.show(res);
	}

	sll.~LinkList();
	return 0;
}

