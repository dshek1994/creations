from django.shortcuts import render
from django.http import HttpResponse

def homepage(request):
    return HttpResponse("My first homepage! Wow so amazing!")
